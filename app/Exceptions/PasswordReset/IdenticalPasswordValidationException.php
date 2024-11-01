<?php

declare(strict_types=1);

namespace App\Exceptions\PasswordReset;

use Symfony\Component\HttpKernel\Exception\HttpException;

final class IdenticalPasswordValidationException extends HttpException
{
}
