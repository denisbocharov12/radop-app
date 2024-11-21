<?php

namespace App\Providers\Theme;

use Darryldecode\Cart\Cart;
use Illuminate\Support\ServiceProvider;

final class WishListProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->singleton('wishlist', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'wishlist';
            $sessionKey = '88uuiioo998821A8';

            return new Cart(
                $storage,
                $events,
                $instanceName,
                $sessionKey,
                config('shopping_cart')
            );
        });
    }
}
