<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->type === 'admin'|| $user->type === 'super_admin';
    }

    public function update(User $user, User $model): bool
    {
        return $user->type === 'admin';
    }

    public function view(User $user, User $model): bool
    {
        return $user->type === 'admin' || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->type === 'admin';
    }
}
