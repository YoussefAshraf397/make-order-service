<?php

declare(strict_types=1);

namespace Support\Guard;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;

class JWTGuard extends \Tymon\JWTAuth\JWTGuard implements Guard
{
    private array $typesNeededToLoad = [
    ];

    private array $typesRelations = [
    ];

    /**
     * Get the currently authenticated user or get the user from DB and authenticate him
     *
     * @return Authenticatable|null
     * @throws AuthenticationException
     */
    public function user(): ?Authenticatable
    {
        return $this->authenticate();
    }
}
