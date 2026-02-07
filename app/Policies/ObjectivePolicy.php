<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Objective;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjectivePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Objective');
    }

    public function view(AuthUser $authUser, Objective $objective): bool
    {
        return $authUser->can('View:Objective');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Objective');
    }

    public function update(AuthUser $authUser, Objective $objective): bool
    {
        return $authUser->can('Update:Objective');
    }

    public function delete(AuthUser $authUser, Objective $objective): bool
    {
        return $authUser->can('Delete:Objective');
    }

    public function restore(AuthUser $authUser, Objective $objective): bool
    {
        return $authUser->can('Restore:Objective');
    }

    public function forceDelete(AuthUser $authUser, Objective $objective): bool
    {
        return $authUser->can('ForceDelete:Objective');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Objective');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Objective');
    }

    public function replicate(AuthUser $authUser, Objective $objective): bool
    {
        return $authUser->can('Replicate:Objective');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Objective');
    }

}