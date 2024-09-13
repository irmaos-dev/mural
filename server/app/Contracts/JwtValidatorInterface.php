<?php

declare(strict_types = 1);

namespace App\Contracts;

interface JwtValidatorInterface
{
    /**
     * Validate JwtToken signature, header, expiration and subject.
     *
     * @param JwtTokenInterface $token
     * @return bool
     */
    public static function validate(JwtTokenInterface $token): bool;
}
