<?php

namespace App\Listeners;

use App\Events\RegisteredRestaurant;
use App\Notifications\RestaurantCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class SendRestaurantWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  RegisteredRestaurant  $event
     * @return void
     */
    public function handle(RegisteredRestaurant $event)
    {
        $password = Str::random(8); 

        $event->user->notify(new RestaurantCreated($event->user, $password));
    }
}