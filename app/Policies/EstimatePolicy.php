<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Estimate;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstimatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the estimate can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the estimate can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Estimate  $model
     * @return mixed
     */
    public function view(User $user, Estimate $model)
    {
        return true;
    }

    /**
     * Determine whether the estimate can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the estimate can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Estimate  $model
     * @return mixed
     */
    public function update(User $user, Estimate $model)
    {
        return true;
    }

    /**
     * Determine whether the estimate can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Estimate  $model
     * @return mixed
     */
    public function delete(User $user, Estimate $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Estimate  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the estimate can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Estimate  $model
     * @return mixed
     */
    public function restore(User $user, Estimate $model)
    {
        return false;
    }

    /**
     * Determine whether the estimate can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Estimate  $model
     * @return mixed
     */
    public function forceDelete(User $user, Estimate $model)
    {
        return false;
    }
}
