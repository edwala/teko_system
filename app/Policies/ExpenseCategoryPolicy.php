<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ExpenseCategory;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpenseCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the expenseCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the expenseCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExpenseCategory  $model
     * @return mixed
     */
    public function view(User $user, ExpenseCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the expenseCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the expenseCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExpenseCategory  $model
     * @return mixed
     */
    public function update(User $user, ExpenseCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the expenseCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExpenseCategory  $model
     * @return mixed
     */
    public function delete(User $user, ExpenseCategory $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExpenseCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the expenseCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExpenseCategory  $model
     * @return mixed
     */
    public function restore(User $user, ExpenseCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the expenseCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ExpenseCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, ExpenseCategory $model)
    {
        return false;
    }
}
