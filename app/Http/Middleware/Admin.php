<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->level != 'admin'){
            
            if(Auth::user()->level == 'librarian'){
                return redirect('books');
            }
            else if(Auth::user()->level == 'student'){
                return redirect('studentBorrow');
            }
            else if(Auth::user()->level == 'lecturer'){
                return redirect('lecturerBorrow');
            }
        }

        return $next($request);
    }
}

