<?php

namespace App\Http\Middleware;

use App\Models\PermissionRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class roleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $route = explode('/', Route::currentRouteName());

        $permission = PermissionRole::is_have_permission($user->id_role, $route[0]);
        
        if ($permission > 0) {
            return $next($request);
        }

        return redirect()->route('no_access');
    }
}
