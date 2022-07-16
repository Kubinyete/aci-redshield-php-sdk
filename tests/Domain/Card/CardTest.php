<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Card\Card;

class CardTest extends TestCase
{
    public function testCanBeCreatedFromValidValues(): void
    {
        $this->assertInstanceOf(
            Card::class,
            Card::fromValues('FLAVIO AUGUSTUS', '5454 5454 5454 5454', '03', '2025')
        );
    }

    public function testCanBeRepresentedAsArray(): void
    {
        $this->assertSame([
            'holder' => 'FLAVIO AUGUSTUS',
            'number' => '5454545454545454',
            'expiryMonth' => '03',
            'expiryYear' => '2025'
        ], Card::fromValues(
            'FLAVIO AUGUSTUS',
            '5454 5454 5454 5454',
            '03',
            '2025'
        )->jsonSerialize());
    }

    public function testCannotBeCreateWithInvalidMonth(): void
    {
        $this->expectException(\DomainException::class);

        Card::fromValues('FLAVIO AUGUSTUS', '5454 5454 5454 5454', '45', '2025');
    }

    public function testCannotBeCreateWithInvalidYear(): void
    {
        $this->expectException(\DomainException::class);

        Card::fromValues('FLAVIO AUGUSTUS', '5454 5454 5454 5454', '12', '25');
    }
}
