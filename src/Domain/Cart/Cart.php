<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Cart;

use Jhernandes\AciRedShield\Domain\Cart\Item;

class Cart implements \JsonSerializable, \Countable, \IteratorAggregate
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public static function fromItems(Item ...$items): self
    {
        $cart = new self();
        foreach ($items as $item) {
            $cart->addItem($item);
        }

        return $cart;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function addItemFromValues(
        string $name,
        float $originalPrice,
        int $quantity,
        string $sku
    ): void {
        $this->items[] = Item::fromValues($name, $originalPrice, $quantity, $sku);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => array_map(fn ($item) => $item->jsonSerialize(), $this->items)
        ];
    }
}
