<?php

namespace App\Observers;

use App\Models\RoleUser;

class RoleUserObserver
{
    private $modelName = 'User';

    /**
     * Handle the RoleUser "created" event.
     */
    public function created(RoleUser $roleUser): void
    {
        $data = [
            'Role' => $roleUser->role->name,
        ];

        storeRecordLog('Update', $this->modelName, $roleUser->user_id, $data);
    }

    /**
     * Handle the RoleUser "updated" event.
     */
    public function updated(RoleUser $roleUser): void
    {
        //
    }

    /**
     * Handle the RoleUser "deleted" event.
     */
    public function deleted(RoleUser $roleUser): void
    {
        $data = [
            'Role' => $roleUser->role->name,
        ];
        
        storeRecordLog('Delete', $this->modelName, $roleUser->user_id, $data);
    }

    /**
     * Handle the RoleUser "restored" event.
     */
    public function restored(RoleUser $roleUser): void
    {
        //
    }

    /**
     * Handle the RoleUser "force deleted" event.
     */
    public function forceDeleted(RoleUser $roleUser): void
    {
        //
    }
}
