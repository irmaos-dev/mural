<?php

declare(strict_types = 1);

namespace App\Jwt;

use App\Contracts\JwtTokenInterface;
use App\Contracts\JwtValidatorInterface;
use App\Models\User;
use Illuminate\Support\Carbon;

final class Validator implements JwtValidatorInterface
{
    public static function validate(JwtTokenInterface $token): bool
    {
        $signature = $token->getUserSignature();

        if (null === $signature) {
            return false;
        }

        if (!hash_equals(Generator::signature($token), $signature)) {
            return false;
        }

        $headers = $token->headers();

        if ('HS256' !== $headers->get('alg')
            || 'JWT' !== $headers->get('typ')) {
            return false;
        }

        $expiresAt = $token->getExpiration();

        if (0 === $expiresAt) {
            return false;
        }
        $expirationDate = Carbon::createFromTimestamp($expiresAt);
        $currentDate = Carbon::now();

        if ($expirationDate->lessThan($currentDate)) {
            return false;
        }

        $subject = $token->getSubject();

        return !(User::whereKey($subject)->doesntExist())

        ;
    }
}
