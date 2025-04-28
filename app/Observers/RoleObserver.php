<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    private $modelName = 'Role';

    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $data = [
            'Name' => $role->name
        ];

        storeRecordLog('Create', $this->modelName, $role->id, $data);
    }

    
    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        $data = [
            'Name' => $role->wasChanged('name') ? $role->name : null,
        ];

        storeRecordLog('Create', $this->modelName, $role->id, $data);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        storeRecordLog('Delete', $this->modelName, $user->id);
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
