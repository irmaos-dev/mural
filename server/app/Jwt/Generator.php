<?php

declare(strict_types = 1);

namespace App\Jwt;

use App\Contracts\JwtGeneratorInterface;
use App\Contracts\JwtSubjectInterface;
use App\Contracts\JwtTokenInterface;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

final class Generator implements JwtGeneratorInterface
{
    public static function signature(JwtTokenInterface $token): string
    {
        $secret = config('app.key');

        if (null === $secret) {
            throw new InvalidArgumentException('No APP_KEY specified.');
        }

        $encodedData = self::encodeData($token);

        return hash_hmac('sha256', $encodedData, $secret);
    }

    public static function token(JwtSubjectInterface $user): string
    {
        $now = Carbon::now();
        $expiresIn = (int) config('jwt.expiration');
        $expiresAt = $now->addSeconds($expiresIn);

        $token = Builder::build()
            ->subject($user)
            ->issuedAt($now->getTimestamp())
            ->expiresAt($expiresAt->getTimestamp())
            ->getToken();

        $parts = [
            self::encodeData($token),
            base64_encode(self::signature($token)),
        ];

        return implode('.', $parts);
    }

    /**
     * Encode JwtToken headers and payload.
     *
     * @param JwtTokenInterface $token
     * @return string
     */
    private static function encodeData(JwtTokenInterface $token): string
    {
        $jsonParts = [
            $token->headers()->toJson(),
            $token->claims()->toJson(),
        ];

        $encoded = array_map('base64_encode', $jsonParts);

        return implode('.', $encoded);
    }
}
