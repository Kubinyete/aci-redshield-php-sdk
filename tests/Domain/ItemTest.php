<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Item;

class ItemTest extends TestCase
{
    public function testCanCreateFromValues(): void
    {
        $this->assertInstanceOf(Item::class, Item::fromValues(
            'PRODUTO DE TESTES',
            9.89,
            1,
            "PT_001"
        ));
    }

    public function testCanBeRepresentedAsArray(): void
    {
        $this->assertEquals([
            'name' => 'PRODUTO DE TESTES',
            'originalPrice' => 9.89,
            'quantity' => 1,
            'sku' => 'PT_001'
        ], Item::fromValues(
            'PRODUTO DE TESTES',
            9.89,
            1,
            "PT_001"
        )->jsonSerialize());
    }

    public function testCannotBeCreatedWithInvalidName(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        Item::fromValues(
            'PRODUTO@TESTES>COM',
            9.89,
            1,
            "PT_001"
        );
    }

    public function testCannotBeCreatedWithLessThanOneItemInQuantity(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        Item::fromValues(
            'PRODUTO DE VALOR 10',
            10.00,
            0,
            "PT_001"
        );
    }

    public function testCannotBeCreatedWithInvalidSkuString(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        Item::fromValues(
            'PRODUTO DE VALOR 10',
            10.00,
            2,
            "******"
        );
    }
}
