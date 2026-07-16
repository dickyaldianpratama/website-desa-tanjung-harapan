<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Carbon\Carbon;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            Visitor::firstOrCreate([
                'ip_address' => $request->ip(),
                'visit_date' => Carbon::today()->toDateString(),
            ]);
        } catch (\Exception $e) {
            // Ignore error so it doesn't break the app if DB is down
        }

        return $next($request);
    }
}
