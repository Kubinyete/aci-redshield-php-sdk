<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Postcode;

class PostcodeTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(Postcode::class, Postcode::fromString('01156-060'));
    }

    public function testCanBeCreatedFromValidString2(): void
    {
        $this->assertInstanceOf(Postcode::class, Postcode::fromString('01156-0601'));
    }

    public function testCannotBeCreatedFromInvalidPostcode(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        Postcode::fromString('012A-123A');
    }
}
