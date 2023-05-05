<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BankStatement;
use App\Enumerators\RoleName;
use App\Enumerators\PermissionName;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class BankStatementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the bankStatement can view any models.
     *
     * @param  Chiiya\FilamentAccessControl\Models\FilamentUser  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {

        //session(['team_id' => $team->team_id]);
        //dd(session('company_id'));
        //dd($user);
        /*
        if( $user->hasRole(RoleName::SUPER_ADMIN)) {
            return true;
        } else {
            return false;
        }
        */
        //return true;
        /*
        if($user->can(PermissionName::VIEW_BANK_STATEMENST)) {
            return true;
        } else {
            return false;
        }
        */
        //return $user->can(PermissionName::VIEW_BANK_STATEMENST);
        return true;

    }

    /**
     * Determine whether the bankStatement can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BankStatement  $model
     * @return mixed
     */
    public function view(User $user, BankStatement $model)
    {
        return true;
    }

    /**
     * Determine whether the bankStatement can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the bankStatement can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BankStatement  $model
     * @return mixed
     */
    public function update(User $user, BankStatement $model)
    {
        return true;
    }

    /**
     * Determine whether the bankStatement can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BankStatement  $model
     * @return mixed
     */
    public function delete(User $user, BankStatement $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BankStatement  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the bankStatement can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BankStatement  $model
     * @return mixed
     */
    public function restore(User $user, BankStatement $model)
    {
        return false;
    }

    /**
     * Determine whether the bankStatement can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BankStatement  $model
     * @return mixed
     */
    public function forceDelete(User $user, BankStatement $model)
    {
        return false;
    }
}
