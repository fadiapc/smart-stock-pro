<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        // Biarkan request berjalan dulu
        $response = $next($request);

        // Setelah itu, catat ke database jika user sudah login
        if (Auth::check()) {
            AuditLog::create([
                'user_name' => Auth::user()->name,
                'action' => 'Mengakses URL: ' . $request->path(),
                'ip_address' => $request->ip(),
            ]);
        }

        return $response;
    }
}