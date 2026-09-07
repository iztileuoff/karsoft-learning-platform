<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Ai\PruneAiHistory;

class AiPruneHistoryCommand extends Command
{
    protected $signature = 'ai:prune-history
                            {--months= : Override history_months from config}
                            {--dry-run : Report what would be deleted without deleting}';

    public function handle(PruneAiHistory $pruner): int
    {
        $months = (int) ($this->option('months') ?: config('gemini.history_months', 1));

        if ($months < 1) {
            $this->error('--months must be at least 1.');
            return self::FAILURE;
        }

        $cutoff = now()->subMonths($months);
        $dryRun = (bool) $this->option('dry-run');

        $this->info(sprintf(
            '%sPruning AI history before %s...',
            $dryRun ? '[DRY RUN] ' : '',
            $cutoff->toDateTimeString()
        ));

        $r = $pruner->execute($cutoff, $dryRun);

        $this->info("Conversations: {$r->conversations}, attachments: {$r->attachments}, files: {$r->files}.");

        return self::SUCCESS;
    }
}
