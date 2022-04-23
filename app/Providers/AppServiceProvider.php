<?php

namespace App\Providers;

use App\Models\GroupMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
	 view()->composer('*', function ($view){
         view()->composer('*', function($view){
           if (Auth::check()) {
	    $my_id = Auth::id();
            $users = GroupMessage::where('is_read', 0)->where('user_id', $my_id)->count();
            $view->with('users', $users );
           }else {
            $view->with('users', 0);
            }
          });
	  view()->composer('*', function($view){
          if (Auth::check()) {
	    $my_id = Auth::id();
            $message = GroupMessage::where('is_read', 0)->where(['user_id' => $my_id])->get();
            $view->with('message', $message );
          }
       });
      });
    }
}
