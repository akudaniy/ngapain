<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KeyResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class KeyResultPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KeyResult');
    }

    public function view(AuthUser $authUser, KeyResult $keyResult): bool
    {
        return $authUser->can('View:KeyResult');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KeyResult');
    }

    public function update(AuthUser $authUser, KeyResult $keyResult): bool
    {
        return $authUser->can('Update:KeyResult');
    }

    public function delete(AuthUser $authUser, KeyResult $keyResult): bool
    {
        return $authUser->can('Delete:KeyResult');
    }

    public function restore(AuthUser $authUser, KeyResult $keyResult): bool
    {
        return $authUser->can('Restore:KeyResult');
    }

    public function forceDelete(AuthUser $authUser, KeyResult $keyResult): bool
    {
        return $authUser->can('ForceDelete:KeyResult');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KeyResult');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KeyResult');
    }

    public function replicate(AuthUser $authUser, KeyResult $keyResult): bool
    {
        return $authUser->can('Replicate:KeyResult');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KeyResult');
    }

}