<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EstimateItem;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstimateItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the estimateItem can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the estimateItem can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EstimateItem  $model
     * @return mixed
     */
    public function view(User $user, EstimateItem $model)
    {
        return true;
    }

    /**
     * Determine whether the estimateItem can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the estimateItem can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EstimateItem  $model
     * @return mixed
     */
    public function update(User $user, EstimateItem $model)
    {
        return true;
    }

    /**
     * Determine whether the estimateItem can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EstimateItem  $model
     * @return mixed
     */
    public function delete(User $user, EstimateItem $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EstimateItem  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the estimateItem can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EstimateItem  $model
     * @return mixed
     */
    public function restore(User $user, EstimateItem $model)
    {
        return false;
    }

    /**
     * Determine whether the estimateItem can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EstimateItem  $model
     * @return mixed
     */
    public function forceDelete(User $user, EstimateItem $model)
    {
        return false;
    }
}
