<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Role;

class UserObserver
{
    private $modelName = 'User';

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $data = [
            'Name' => $user->name,
            'Email' => $user->email
        ];

        storeRecordLog('Create', $this->modelName, $user->id, $data);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Only trigger the log if one of these fields is changed.
        if (!$user->wasChanged(['name', 'email', 'password'])) {
            return;
        }
        
        $data = [
            'Name' => $user->wasChanged('name') ? $user->name : null,
            'Email' => $user->wasChanged('email') ? $user->email : null,
            'Password' => $user->wasChanged('password') ? '********' : null
        ];

        storeRecordLog('Update', $this->modelName, $user->id, $data);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        storeRecordLog('Delete', $this->modelName, $user->id);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
