<?php

declare(strict_types = 1);

namespace App\Contracts;

interface JwtGeneratorInterface
{
    /**
     * Generate JWT signature.
     *
     * @param JwtTokenInterface $token
     * @return string
     */
    public static function signature(JwtTokenInterface $token): string;

    /**
     * Generate JWT string.
     *
     * @param JwtSubjectInterface $user
     * @return string
     */
    public static function token(JwtSubjectInterface $user): string;
}
