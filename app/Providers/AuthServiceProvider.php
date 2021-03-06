<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Start of Gate
        Gate::define('isAdmin',function($user){
          return $user->type==='admin';
        });

        Gate::define('isAuthor',function($user){
          return $user->type==='author';
        });

        Gate::define('isUser',function($user){
          return $user->type==='user';
        });
        
        Gate::define('isAdminOrAuthor',function($user){
          if ($user->type==='author' || $user->type==='admin') {
            return true;
            // code...
          }
        });
            // End  of Gate
        //Start for passport
         Passport::routes();
        //End for passport
    }
}
