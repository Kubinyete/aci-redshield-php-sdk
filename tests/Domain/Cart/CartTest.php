<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Cart\Cart;
use Jhernandes\AciRedShield\Domain\Cart\Item;

class CartTest extends TestCase
{
    public function testCanBeCreatedFromValidItems(): void
    {
        $this->assertInstanceOf(Cart::class, Cart::fromItems(
            Item::fromValues('Item 1', 1.00, 1, 'ITEM1'),
            Item::fromValues('Item 2', 2.00, 1, 'ITEM2'),
            Item::fromValues('Item 3', 3.00, 1, 'ITEM3'),
            Item::fromValues('Item 4', 4.00, 1, 'ITEM4'),
        ));
    }

    public function testCanBeAddedNewItems(): void
    {
        $cart = Cart::fromItems(
            Item::fromValues('Item 1', 1.00, 1, 'ITEM1'),
        );
        $cart->addItemFromValues('Item 2', 2.00, 1, 'ITEM2');

        $this->assertCount(2, $cart);
    }

    public function testCanBeConvertedToArray(): void
    {
        $this->assertSame([
            'items' => [
                [
                    "name" => 'Item 1',
                    "originalPrice" => '1.00',
                    "quantity" => 1,
                    "sku" => 'ITEM1'
                ]
            ],
        ], Cart::fromItems(
            Item::fromValues('Item 1', 1.0, 1, 'ITEM1'),
        )->jsonSerialize());
    }
}
