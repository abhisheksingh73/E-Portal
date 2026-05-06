<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if (auth()->user()->role !== $role) {
            // Redirect based on their actual role if they try to access wrong dashboard
            $userRole = auth()->user()->role;
            if ($userRole == 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($userRole == 'seller') {
                return redirect('/seller/dashboard');
            } else {
                return redirect('/buyer/dashboard');
            }
        }

        return $next($request);
    }
}
