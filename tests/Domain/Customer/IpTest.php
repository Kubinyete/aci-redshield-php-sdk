<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Customer\Ip;

class IpTest extends TestCase
{
    public function testCanBeCreatedFromValidIpv4(): void
    {
        $this->assertInstanceOf(
            Ip::class,
            Ip::fromString('127.0.0.1')
        );
    }

    public function testCanBeCreatedFromValidIpv6(): void
    {
        $this->assertInstanceOf(
            Ip::class,
            Ip::fromString('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
        );
    }

    public function testCannotBeCreatedFromInvalidIp(): void
    {
        $this->expectException(\DomainException::class);

        Ip::fromString('127001');
    }
}
