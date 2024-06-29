<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\User;

class TestPolicy
{
    public function view(User $user, Test $test): bool
    {
        return $user->id === $test->user_id;
    }

    public function update(User $user, Test $test): bool
    {
        return $user->id === $test->user_id;
    }
}
