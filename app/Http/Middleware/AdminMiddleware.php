<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }

        $user = Auth::user();
        
        if (!$user->role) {
            return redirect()->route('dashboard')->with('error', 'شما دسترسی لازم را ندارید.');
        }

        $userRole = $user->role->name;
        
        // Only admin can access
        if (!in_array($userRole, ['مدیر', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'فقط مدیران می‌توانند به این بخش دسترسی داشته باشند.');
        }

        return $next($request);
    }
}

