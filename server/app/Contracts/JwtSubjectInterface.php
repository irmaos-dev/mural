<?php

declare(strict_types = 1);

namespace App\Contracts;

interface JwtSubjectInterface
{
    /**
     * Get JWT subject identifier (User Key).
     *
     * @return mixed
     */
    public function getJwtIdentifier(): mixed;
}
