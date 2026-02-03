<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DailyAccomplishment;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyAccomplishmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DailyAccomplishment');
    }

    public function view(AuthUser $authUser, DailyAccomplishment $dailyAccomplishment): bool
    {
        return $authUser->can('View:DailyAccomplishment') && ($authUser->hasAnyRole(['super_admin', 'manager']) || $dailyAccomplishment->user_id === $authUser->getAuthIdentifier());
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DailyAccomplishment');
    }

    public function update(AuthUser $authUser, DailyAccomplishment $dailyAccomplishment): bool
    {
        return $authUser->can('Update:DailyAccomplishment') && ($dailyAccomplishment->user_id === $authUser->getAuthIdentifier());
    }

    public function delete(AuthUser $authUser, DailyAccomplishment $dailyAccomplishment): bool
    {
        return $authUser->can('Delete:DailyAccomplishment') && ($dailyAccomplishment->user_id === $authUser->getAuthIdentifier());
    }

    public function restore(AuthUser $authUser, DailyAccomplishment $dailyAccomplishment): bool
    {
        return $authUser->can('Restore:DailyAccomplishment') && ($dailyAccomplishment->user_id === $authUser->getAuthIdentifier());
    }

    public function forceDelete(AuthUser $authUser, DailyAccomplishment $dailyAccomplishment): bool
    {
        return $authUser->can('ForceDelete:DailyAccomplishment') && ($dailyAccomplishment->user_id === $authUser->getAuthIdentifier());
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DailyAccomplishment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DailyAccomplishment');
    }

    public function replicate(AuthUser $authUser, DailyAccomplishment $dailyAccomplishment): bool
    {
        return $authUser->can('Replicate:DailyAccomplishment') && ($dailyAccomplishment->user_id === $authUser->getAuthIdentifier());
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DailyAccomplishment');
    }

}