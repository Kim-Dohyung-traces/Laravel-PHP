<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // $this->registerPolicies();

        //관리자 권한   app\User참고
        Gate::before(function ($user) {
            if ($user->isAdmin()) return true;
        });

        //수정권한
        Gate::define('update', function ($user, $model) {
            //사용자 아이디와 모델의 user_id속성이 같은지를 비교 
            return $user->id === $model->user_id;
        });

        //삭제권한
        Gate::define('delete', function ($user, $model) {
            return $user->id === $model->user_id;
        });
    }
}