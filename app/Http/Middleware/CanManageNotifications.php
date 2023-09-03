<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CanManageNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Gate::allows('manage')) {
            return $next($request);
        }

        session()->flash('error', 'You are not authorized to manage notifications.');
        return redirect()->route('errors')->with('error', 'You are not authorized to manage notifications.');
    }
}
