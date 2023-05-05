<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the invoice can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the invoice can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Invoice  $model
     * @return mixed
     */
    public function view(User $user, Invoice $model)
    {
        return true;
    }

    /**
     * Determine whether the invoice can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the invoice can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Invoice  $model
     * @return mixed
     */
    public function update(User $user, Invoice $model)
    {
        return true;
    }

    /**
     * Determine whether the invoice can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Invoice  $model
     * @return mixed
     */
    public function delete(User $user, Invoice $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Invoice  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the invoice can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Invoice  $model
     * @return mixed
     */
    public function restore(User $user, Invoice $model)
    {
        return false;
    }

    /**
     * Determine whether the invoice can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Invoice  $model
     * @return mixed
     */
    public function forceDelete(User $user, Invoice $model)
    {
        return false;
    }
}
