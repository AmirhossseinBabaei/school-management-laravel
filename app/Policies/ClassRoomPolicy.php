<?php

namespace App\Policies;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;

class ClassRoomPolicy
{
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasRole('admin') ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, ClassRoom $classRoom): bool
    {
        if ($authUser->hasRole('admin')) {
            return true;
        } else {
            if ($authUser->school_id === $classRoom->school_id) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, ClassRoom $classRoom): bool
    {
        if ($authUser->hasRole('admin')) {
            return true;
        } else {
            if ($authUser->school_id === $classRoom->school_id) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, ClassRoom $classRoom): bool
    {
        if ($authUser->hasRole('admin')) {

            return true;
        } else {
            if ($authUser->school_id === $classRoom->school_id) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
