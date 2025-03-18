<?php

namespace App\Policies;

use App\Models\Todolist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TodolistPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Todolist $todolist): Response
    {
        return $user->id === $todolist->user_id
        ? Response::allow()
        : Response::deny('You do not own this todolist. can`t view');
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
    public function update(User $user, Todolist $todolist): Response
    {
        return $user->id === $todolist->user_id
        ? Response::allow()
        : Response::deny('You do not own this todolist. can`t update.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todolist $todolist): Response
    {
        return $user->id === $todolist->user_id
        ? Response::allow()
        : Response::deny('You do not own this todolist. can`t delete.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Todolist $todolist): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Todolist $todolist): bool
    {
        return false;
    }
}
