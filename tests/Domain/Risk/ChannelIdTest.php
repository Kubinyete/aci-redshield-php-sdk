<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\Risk\ChannelId;
use PHPUnit\Framework\TestCase;

class ChannelIdTest extends TestCase
{
    private const CHANNELID = '000668000001';

    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(ChannelId::class, ChannelId::fromString(self::CHANNELID));
    }

    public function testCanBeRepresentedAsString(): void
    {
        $case = '123456871001';
        $this->assertSame($case, (string) ChannelId::fromString($case));
    }

    public function testCannotBeCreatedFromInvalidString(): void
    {
        $this->expectException(\DomainException::class);

        ChannelId::fromString('000156');
    }
}
