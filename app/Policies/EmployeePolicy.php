<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employee can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the employee can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Employee  $model
     * @return mixed
     */
    public function view(User $user, Employee $model)
    {
        return true;
    }

    /**
     * Determine whether the employee can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the employee can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Employee  $model
     * @return mixed
     */
    public function update(User $user, Employee $model)
    {
        return true;
    }

    /**
     * Determine whether the employee can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Employee  $model
     * @return mixed
     */
    public function delete(User $user, Employee $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Employee  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the employee can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Employee  $model
     * @return mixed
     */
    public function restore(User $user, Employee $model)
    {
        return false;
    }

    /**
     * Determine whether the employee can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Employee  $model
     * @return mixed
     */
    public function forceDelete(User $user, Employee $model)
    {
        return false;
    }
}
