<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = Session::get('lastActivityTime');
            $currentTime = Carbon::now('Asia/Manila');

            if ($lastActivity && $currentTime->diffInMinutes($lastActivity) >= 1) {
                $user = Auth::user();
                $user->update(['secured_account' => null]);

                Auth::logout();
                Session::flush();
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }

            session(['lastActivityTime' => Carbon::now('Asia/Manila')]);
        }
        return $next($request);
    }
}
