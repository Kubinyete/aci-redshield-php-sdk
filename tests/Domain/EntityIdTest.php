<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\EntityId;

class EntityIdTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            EntityId::class,
            EntityId::fromString('8ac7a4ca80d226b40180d238310b007d')
        );
    }

    public function testCannotBeCreatedFromInvalidString(): void
    {
        $this->expectException(\DomainException::class);

        EntityId::fromString('8ac7a4ca80d226-40180d-3831-b007d');
    }

    public function testCannotBeCreatedFromStringWithWrongLength(): void
    {
        $this->expectException(\DomainException::class);

        EntityId::fromString('8ac7a4ca80d226');
    }
}
