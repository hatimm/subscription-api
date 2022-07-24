<?php

namespace App\Console\Commands;

use App\Models\Website;
use App\Notifications\NewStoryAdded;
use Illuminate\Console\Command;

class SendNewPostEmailByWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:new-post-email-by-website {website}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send specific website\'s new post email to all subscribed users';

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
        $website = Website::where('url', $this->argument('website'))->first();

        if ($website) {
            $subscribedUsers = $website->users;
            $posts = $website->posts;

            foreach ($subscribedUsers as $user) {
                foreach ($posts as $post) {
                    if (!$user->posts->contains($post->id)) {
                        $this->info('postId: ' . $post->id . ', email was successfully send to queue!');
                        $user->posts()->save($post);
                        $user->notify(new NewStoryAdded($post));
                    }
                }
            }
        } else {
            $this->info('Website not found!!');
        }
    }
}
