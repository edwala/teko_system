<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Template;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the template can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the template can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Template  $model
     * @return mixed
     */
    public function view(User $user, Template $model)
    {
        return true;
    }

    /**
     * Determine whether the template can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the template can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Template  $model
     * @return mixed
     */
    public function update(User $user, Template $model)
    {
        return true;
    }

    /**
     * Determine whether the template can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Template  $model
     * @return mixed
     */
    public function delete(User $user, Template $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Template  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the template can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Template  $model
     * @return mixed
     */
    public function restore(User $user, Template $model)
    {
        return false;
    }

    /**
     * Determine whether the template can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Template  $model
     * @return mixed
     */
    public function forceDelete(User $user, Template $model)
    {
        return false;
    }
}
