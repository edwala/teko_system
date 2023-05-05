<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the client can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the client can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Client  $model
     * @return mixed
     */
    public function view(User $user, Client $model)
    {
        return true;
    }

    /**
     * Determine whether the client can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the client can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Client  $model
     * @return mixed
     */
    public function update(User $user, Client $model)
    {
        return true;
    }

    /**
     * Determine whether the client can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Client  $model
     * @return mixed
     */
    public function delete(User $user, Client $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Client  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the client can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Client  $model
     * @return mixed
     */
    public function restore(User $user, Client $model)
    {
        return false;
    }

    /**
     * Determine whether the client can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Client  $model
     * @return mixed
     */
    public function forceDelete(User $user, Client $model)
    {
        return false;
    }
}
