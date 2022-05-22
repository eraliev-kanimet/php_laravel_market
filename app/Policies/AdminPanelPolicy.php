<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPanelPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool|void
     */
    public function before(User $user)
    {
        if ($user->roles->contains('slug', 'admin')) {
            return true;
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function createOrUpdateOrDeleteOrGetProducts(User $user): bool
    {
        return $user->roles->contains('slug', 'seller');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function createOrUpdateOrDeleteOrGetCategories(User $user): bool
    {
        return $user->roles->contains('slug', 'seller');
    }
}
