<?php

namespace App\Services\Ai;

use App\Models\AiAttachment;
use App\Models\AiConversation;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final readonly class PruneAiHistory
{
    private const CHUNK = 200;

    public function __construct(private Filesystem $disk) {}

    public function execute(CarbonInterface $cutoff, bool $dryRun = false): PruneReport
    {
        $report = new PruneReport();

        $this->staleConversations($cutoff)
            ->select('id')
            ->chunkById(self::CHUNK, function ($chunk) use ($dryRun, $report): void {
                $ids = $chunk->modelKeys();

                $paths = AiAttachment::query()
                    ->whereHas('message', fn (Builder $q) => $q->whereIn('ai_conversation_id', $ids))
                    ->pluck('path');

                $report->conversations += count($ids);
                $report->attachments   += $paths->count();

                if ($dryRun) {
                    return;
                }

                DB::transaction(function () use ($ids): void {
                    AiAttachment::query()
                        ->whereHas('message', fn (Builder $q) => $q->whereIn('ai_conversation_id', $ids))
                        ->delete();

                    AiConversation::whereIn('id', $ids)->delete();
                });

                $report->files += $this->deleteFiles($paths);
            });

        $report->files += $this->pruneOrphans($cutoff, $dryRun, $report);

        return $report;
    }

    private function staleConversations(CarbonInterface $cutoff): Builder
    {
        return AiConversation::query()->where(
            fn (Builder $q) => $q
                ->where('last_message_at', '<', $cutoff)
                ->orWhere(fn (Builder $q2) => $q2
                    ->whereNull('last_message_at')
                    ->where('created_at', '<', $cutoff)
                )
        );
    }

    private function pruneOrphans(CarbonInterface $cutoff, bool $dryRun, PruneReport $report): int
    {
        $deleted = 0;

        AiAttachment::query()
            ->whereNull('ai_message_id')
            ->where('created_at', '<', $cutoff)   // ← muhim
            ->chunkById(self::CHUNK, function ($chunk) use ($dryRun, $report, &$deleted): void {
                $report->attachments += $chunk->count();

                if ($dryRun) {
                    return;
                }

                $deleted += $this->deleteFiles($chunk->pluck('path'));
                AiAttachment::whereIn('id', $chunk->modelKeys())->delete();
            });

        return $deleted;
    }

    private function deleteFiles(iterable $paths): int
    {
        $count = 0;

        foreach ($paths as $path) {
            if (blank($path) || ! $this->disk->exists($path)) {
                continue;
            }

            if ($this->disk->delete($path)) {
                $count++;
                continue;
            }

            report(new \RuntimeException("Failed to delete AI attachment: {$path}"));
        }

        return $count;
    }
}