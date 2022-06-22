<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Customer\CustomerId;

class CustomerIdTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $this->assertInstanceOf(CustomerId::class, CustomerId::fromString('ABCD123456789'));
    }

    public function testCannotBeCreatedFromInvalidString(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        CustomerId::fromString('!@#$%ˆ*ˆ&*(&');
    }

    public function testCannotBeCreatedFromEmptyString(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        CustomerId::fromString('');
    }

    public function testCannotBeCreatedFromMoreThan32Characters(): void
    {
        $text = sha1('Cannot be greater than this');

        $this->assertGreaterThan(32, strlen($text));
        $this->expectException(\UnexpectedValueException::class);

        CustomerId::fromString($text);
    }
}
