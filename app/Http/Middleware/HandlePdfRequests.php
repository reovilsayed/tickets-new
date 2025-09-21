<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandlePdfRequests
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
        $response = $next($request);

        // Add CORS headers for PDF files
        if ($request->is('storage/*') && $request->header('Accept') === 'application/pdf') {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, HEAD, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Range, Content-Type');
            $response->headers->set('Access-Control-Expose-Headers', 'Content-Length, Content-Range');
            $response->headers->set('Access-Control-Max-Age', '86400');
        }

        // Handle range requests for PDF files
        if ($request->is('storage/*') && $request->hasHeader('Range')) {
            $response->headers->set('Accept-Ranges', 'bytes');
            $response->headers->set('Cache-Control', 'public, max-age=31536000');
        }

        return $response;
    }
}
