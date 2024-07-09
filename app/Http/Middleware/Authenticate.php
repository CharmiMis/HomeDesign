<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $currentRoute = '';
        $currentUrl = url()->current();
        if (strpos($currentUrl, 'redesign') !== false) {
            $currentRoute = 'login';
        } elseif (strpos($currentUrl, 'precision') !== false) {
            $currentRoute = 'login.pricision';
        } elseif (strpos($currentUrl, 'paint-visualizer') !== false) {
            $currentRoute = 'login.paintVisulizer';
        }else{
            $currentRoute = 'login';
        }
        return $request->expectsJson() ? null : route($currentRoute);
    }
}
