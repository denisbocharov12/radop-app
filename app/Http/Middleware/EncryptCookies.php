<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    public function __construct(Encrypter $encrypter)
    {
        parent::__construct($encrypter);

        // whitecube/laravel-cookie-consent writes its consent cookie from routes
        // that run OUTSIDE the encrypted "web" stack (plaintext). It must therefore
        // be read as plaintext too — otherwise decryption fails and the consent
        // banner reappears on every reload / navigation after acceptance.
        $this->disableFor((string) config('cookieconsent.cookie.name'));
    }
}
