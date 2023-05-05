<?php declare(strict_types=1);

namespace App\Enumerators;

class PermissionName
{
    /** @var string */
    public const UPDATE_ADMIN_USERS = 'admin-users.update';

    /** @var string */
    public const UPDATE_PERMISSIONS = 'permissions.update';

    /** @var string */
    public const VIEW_BANK_STATEMENST = 'bank-statements.view';
}
