<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Simple admin check menggunakan session
        // Anda bisa mengubah ini dengan authentication yang lebih kompleks jika diperlukan
        if (!session()->has('admin_logged_in') || !session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Anda harus login sebagai admin terlebih dahulu.');
        }

        return $next($request);
    }
}
