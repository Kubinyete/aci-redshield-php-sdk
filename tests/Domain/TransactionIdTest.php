<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\TransactionId;
use PHPUnit\Framework\TestCase;

class TransactionIdTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(TransactionId::class, TransactionId::fromString('123456'));
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(\DomainException::class);

        TransactionId::fromString('');
    }

    public function testCannotBeCreatedFromStringGreaterThan40Characters(): void
    {
        $this->expectException(\DomainException::class);

        TransactionId::fromString('12345678901234567890123456789012345678901');
    }

    public function testCannotBeCreatedFromInvalidString(): void
    {
        $this->expectException(\DomainException::class);

        TransactionId::fromString(sha1('Invalid TransactionId'));
    }
}
