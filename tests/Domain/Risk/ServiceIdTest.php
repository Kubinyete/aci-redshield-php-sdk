<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\Risk\ServiceId;
use PHPUnit\Framework\TestCase;

class ServiceIdTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(ServiceId::class, ServiceId::fromString('I'));
    }

    public function testCanBeRepresentedAsString(): void
    {
        $serviceId = ServiceId::fromString('J');
        $this->assertIsString((string) $serviceId);
        $this->assertSame('J', (string) $serviceId);
    }

    public function testCannotBeCreatedFromInvalidString(): void
    {
        $this->expectException(\DomainException::class);

        ServiceId::fromString('12');
    }
}
