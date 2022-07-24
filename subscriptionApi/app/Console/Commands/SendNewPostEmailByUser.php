<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Website;
use App\Notifications\NewStoryAdded;
use Illuminate\Console\Command;

class SendNewPostEmailByUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:new-post-email-by-user {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send specific user\'s subscribed websites email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::where('email', $this->argument('user'))->first();

        if ($user) {
            $subscribedWebsites = $user->websites;

            foreach ($subscribedWebsites as $website) {
                foreach ($website->posts as $post) {
                    if (!$user->posts->contains($post->id)) {
                        $this->info('postId: ' . $post->id . ', email was successfully send to queue!');
                        $user->posts()->save($post);
                        $user->notify(new NewStoryAdded($post));
                    }
                }
            }
        } else {
            $this->info('User not found!!');
        }
    }
}
