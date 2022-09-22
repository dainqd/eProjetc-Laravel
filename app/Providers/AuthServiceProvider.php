<?php

namespace App\Providers;

use App\Models\ExtraClass;
use App\Models\Feedback;
use App\Models\Group;
use App\Models\Resource;
use App\Models\Score;
use App\Models\User;
use App\Policies\ExtraClassPolicy;
use App\Policies\FeedbackPolicy;
use App\Policies\GroupPolicy;
use App\Policies\ResourcePolicy;
use App\Models\Test;
use App\Policies\ScorePolicy;
use App\Policies\TestPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Group::class => GroupPolicy::class,
        ExtraClass::class => ExtraClassPolicy::class,
        Resource::class => ResourcePolicy::class,
        Test::class => TestPolicy::class,
        Feedback::class => FeedbackPolicy::class,
        Score::class => ScorePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
