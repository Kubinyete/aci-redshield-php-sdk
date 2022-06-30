<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Application\RedShield\Token;

class TokenTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            Token::class,
            Token::fromString('OGFjN2E0ZDgwOWdiOGRmZzc4OTZhc2Q4N2FzOTBkamt8MTIzNDU2Nzg5')
        );
    }

    public function testCannotBeCreatedFromInvalidBase64Token(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        Token::fromString('123456789');
    }

    public function testCannotBeCreatedFromInvalidToken(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        Token::fromString('OGFjN2E0ZDgwOWdiOGRmZzc4OTZhc2Q4N2FzOTBkamsxMjM0NTY3ODk=');
    }
}
