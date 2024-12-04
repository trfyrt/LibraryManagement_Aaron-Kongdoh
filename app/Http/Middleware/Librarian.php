<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Librarian
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->level != 'librarian' && Auth::user()->level != 'admin'){
            
            if(Auth::user()->level == 'lecturer'){
                return redirect('lecturerBorrow');
            }
            else if(Auth::user()->level == 'student'){
                return redirect('studentBorrow');
            }
        }

        return $next($request);
    }
}

