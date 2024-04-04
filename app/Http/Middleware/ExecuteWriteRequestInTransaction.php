<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class ExecuteWriteRequestInTransaction
{
    private const HTTP_WRITE_METHODS = [
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->shouldExecuteInTransaction($request)) {
            return $next($request);
        }

        DB::beginTransaction();

        $response = $next($request);

        if ($response->status() >= Response::HTTP_BAD_REQUEST) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $response;
    }

    private function shouldExecuteInTransaction(Request $request): bool
    {
        return in_array($request->getMethod(), self::HTTP_WRITE_METHODS, true);
    }
}
