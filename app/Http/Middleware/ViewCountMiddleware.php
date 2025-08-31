<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\ViewCount\ViewCountManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final class ViewCountMiddleware
{
    private const VIEW_COOLDOWN_MINUTES = 30;

    public function __construct(
        private readonly ViewCountManager $viewCountManager
    ) {
    }

    public function handle(Request $request, Closure $next, string $entityType): Response
    {
        $ipAddress = $this->viewCountManager->getClientIp();
        $sessionId = $request->session()->getId();
        
        $entityId = $this->getEntityId($request, $entityType);
        
        if ($entityId === null) {
            return $next($request);
        }
        
        $cacheKey = "view_count_{$entityType}_{$entityId}_{$ipAddress}_{$sessionId}";
        
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, true, now()->addMinutes(self::VIEW_COOLDOWN_MINUTES));
            
            $request->attributes->set('should_increment_view', true);
        } else {
            $request->attributes->set('should_increment_view', false);
        }

        return $next($request);
    }

    private function getEntityId(Request $request, string $entityType): ?string
    {
        return match ($entityType) {
            'product' => $request->route('slug'),
            'brand' => $request->route('onecId'),
            'category' => $request->route('onecId'),
            default => null,
        };
    }
} 