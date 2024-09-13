<?php

declare(strict_types = 1);

namespace Tests\Unit\Jwt;

use App\Exceptions\JwtParseException;
use App\Jwt\Parser;
use JsonException;
use PHPUnit\Framework\TestCase;

final class JwtParserTest extends TestCase
{
    public function testParseParts(): void
    {
        $this->expectException(JwtParseException::class);

        Parser::parse('string');
    }

    public function testParseNotBase64(): void
    {
        $this->expectException(JwtParseException::class);

        Parser::parse('string@.string#.string*');
    }

    public function testParseNotJson(): void
    {
        $this->expectException(JsonException::class);

        Parser::parse('b25l.dHdv.dGhyZWU=');
    }
}
