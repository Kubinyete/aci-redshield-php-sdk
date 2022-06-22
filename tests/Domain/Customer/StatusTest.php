<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Customer\Status;

class StatusTest extends TestCase
{
    public function testCanBeCreatedWithNew(): void
    {
        $this->assertSame('NEW', (string) Status::fromString('NEW'));
    }

    public function testCanBeCreatedWithExisting(): void
    {
        $this->assertSame('EXISTING', (string) Status::fromString('EXISTING'));
    }

    public function testIfCreatedWithInvalidStringNewWillBeUsed(): void
    {
        $this->assertSame('NEW', (string) Status::fromString('ABCDEFG'));
    }
}
