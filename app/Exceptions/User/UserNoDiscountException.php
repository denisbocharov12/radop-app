<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserNoDiscountException extends Exception
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __('theme.user-no-discount-exception'),
        ], 403);
    }
}
