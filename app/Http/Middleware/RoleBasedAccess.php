<?php

namespace App\Http\Middleware;

use App\Enums\UserTypes;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedAccess
{
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     public function handle(Request $request, Closure $next, ...$roles): Response
     {
        if (!$request->user()) {
            return redirect()->route('login');
        }
        // Get user's role directly as an integer
        $userRole = (int)$request->user()->role;
        // Convert string role parameters to integers
        $allowedRoles = array_map(function($role) {
            return (int)$role;
        }, explode(',', implode(',', $roles)));
        // Check if user's role is in allowed roles
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
     }
}
