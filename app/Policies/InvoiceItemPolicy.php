<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InvoiceItem;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoiceItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the invoiceItem can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the invoiceItem can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoiceItem  $model
     * @return mixed
     */
    public function view(User $user, InvoiceItem $model)
    {
        return true;
    }

    /**
     * Determine whether the invoiceItem can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the invoiceItem can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoiceItem  $model
     * @return mixed
     */
    public function update(User $user, InvoiceItem $model)
    {
        return true;
    }

    /**
     * Determine whether the invoiceItem can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoiceItem  $model
     * @return mixed
     */
    public function delete(User $user, InvoiceItem $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoiceItem  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the invoiceItem can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoiceItem  $model
     * @return mixed
     */
    public function restore(User $user, InvoiceItem $model)
    {
        return false;
    }

    /**
     * Determine whether the invoiceItem can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InvoiceItem  $model
     * @return mixed
     */
    public function forceDelete(User $user, InvoiceItem $model)
    {
        return false;
    }
}
