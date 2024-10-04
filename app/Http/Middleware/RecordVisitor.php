<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Support\Facades\Session;

class RecordVisitor
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
        // Get the visitor's IP address
        $visitorIp = $request->ip();

        // Get the current session ID
        $sessionId = Session::getId();

        // Check if the visitor's IP and session ID combination already exists in the database
        $existingVisitor = Visitor::where('ip_address', $visitorIp)
            ->where('session_id', $sessionId)
            ->first();

        // If the visitor's IP and session ID combination doesn't exist, count the visit
        if (!$existingVisitor) {
            $url = $request->fullUrl();

            // Store the visitor's information in the database
            Visitor::create([
                'ip_address' => $visitorIp,
                'session_id' => $sessionId,
                'url' => $url
            ]);
        }

        return $next($request);
    }
}
