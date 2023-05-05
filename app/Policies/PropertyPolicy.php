<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Property;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the property can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the property can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Property  $model
     * @return mixed
     */
    public function view(User $user, Property $model)
    {
        return true;
    }

    /**
     * Determine whether the property can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the property can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Property  $model
     * @return mixed
     */
    public function update(User $user, Property $model)
    {
        return true;
    }

    /**
     * Determine whether the property can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Property  $model
     * @return mixed
     */
    public function delete(User $user, Property $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Property  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the property can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Property  $model
     * @return mixed
     */
    public function restore(User $user, Property $model)
    {
        return false;
    }

    /**
     * Determine whether the property can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Property  $model
     * @return mixed
     */
    public function forceDelete(User $user, Property $model)
    {
        return false;
    }
}
