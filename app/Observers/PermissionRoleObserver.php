<?php

namespace App\Observers;

use App\Models\PermissionRole;

class PermissionRoleObserver
{
    private $modelName = 'Role';

    /**
     * Handle the PermissionRole "created" event.
     */
    public function created(PermissionRole $permissionRole): void
    {
        $data = [
            'Permission' => $permissionRole->permission->name,
        ];

        storeRecordLog('Update', $this->modelName, $permissionRole->role_id, $data);
    }

    /**
     * Handle the PermissionRole "updated" event.
     */
    public function updated(PermissionRole $permissionRole): void
    {
        //
    }

    /**
     * Handle the PermissionRole "deleted" event.
     */
    public function deleted(PermissionRole $permissionRole): void
    {
        $data = [
            'Permission' => $permissionRole->permission->name,
        ];

        storeRecordLog('Delete', $this->modelName, $permissionRole->role_id, $data);
    }

    /**
     * Handle the PermissionRole "restored" event.
     */
    public function restored(PermissionRole $permissionRole): void
    {
        //
    }

    /**
     * Handle the PermissionRole "force deleted" event.
     */
    public function forceDeleted(PermissionRole $permissionRole): void
    {
        //
    }
}
