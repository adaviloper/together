<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentOrganization
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $request->session()->has('current_organization_id')) {
            $first = $user->organizations()->value('organizations.id');

            if ($first) {
                $request->session()->put('current_organization_id', $first);
            }
        }

        return $next($request);
    }
}
