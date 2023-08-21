<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    //
  }

  public function boot(): void
  {
    View::composer('*', function ($view) {
      if (auth()->check()) {
        $view->with('isAdmin', auth()->user()->role === 'admin');
      } else {
        $view->with('isAdmin', false);
      }
    });
  }
}