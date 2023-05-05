<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the document can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the document can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Document  $model
     * @return mixed
     */
    public function view(User $user, Document $model)
    {
        return true;
    }

    /**
     * Determine whether the document can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the document can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Document  $model
     * @return mixed
     */
    public function update(User $user, Document $model)
    {
        return true;
    }

    /**
     * Determine whether the document can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Document  $model
     * @return mixed
     */
    public function delete(User $user, Document $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Document  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the document can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Document  $model
     * @return mixed
     */
    public function restore(User $user, Document $model)
    {
        return false;
    }

    /**
     * Determine whether the document can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Document  $model
     * @return mixed
     */
    public function forceDelete(User $user, Document $model)
    {
        return false;
    }
}
