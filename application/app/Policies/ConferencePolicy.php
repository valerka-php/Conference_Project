<?php

namespace App\Policies;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConferencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Conference $conference
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Conference $conference)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isAnnouncer();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Conference $conference
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Conference $conference)
    {
        return $user->isAdmin() || $conference->creator_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Conference $conference
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Conference $conference)
    {
        return $user->isAdmin() || $conference->creator_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Conference $conference
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Conference $conference)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Conference $conference
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Conference $conference)
    {
        //
    }
}
