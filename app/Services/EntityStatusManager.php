<?php

namespace App\Services;

final class EntityStatusManager
{
    public function getEntityStatusFromRequest(string $statusFromRequest): bool
    {
        if ($statusFromRequest === 'true')
        {
            return $status = true;
        } else return $status = false;
    }
}
