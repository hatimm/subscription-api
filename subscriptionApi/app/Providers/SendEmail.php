<?php

namespace App\Providers;

use App\Models\Post;
use App\Notifications\NewStoryAdded;
use App\Providers\NewStoryPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\NewStoryPosted  $event
     * @return void
     */
    public function handle(NewStoryPosted $event)
    {
        $subscribedUsers = $event->website->users;

        foreach ($subscribedUsers as $user) {
            if (! $user->posts->contains($event->post->id)) {
                $user->posts()->save($event->post);
                $user->notify(new NewStoryAdded($event->post));
            }
        }
    }
}
