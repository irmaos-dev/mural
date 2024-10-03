<?php

declare(strict_types = 1);

namespace App\Contracts;

interface JwtParserInterface
{
    /**
     * Parse JWT and return JwtToken instance.
     * Use JwtValidator to verify the token.
     *
     * @param string $token
     * @return JwtTokenInterface
     * @see \App\Contracts\JwtValidatorInterface::validate()
     */
    public static function parse(string $token): JwtTokenInterface;
}
