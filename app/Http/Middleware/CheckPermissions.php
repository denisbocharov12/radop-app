<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final class CheckPermissions
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $routeName = $request->route()->getName();

        if ($user === null || $routeName === null || !$user->can($routeName)) {
            throw new AccessDeniedHttpException('Access Denied', null, Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
