<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class Cart implements \JsonSerializable
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public static function fromItems(array $items): self
    {
        $cart = new self();
        foreach ($items as $item) {
            $item = (object) $item;
            $cart->addItem(
                $item->name,
                $item->originalPrice,
                $item->quantity,
                $item->sku,
            );
        }

        return $cart;
    }

    public function addItem(
        string $name,
        float $originalPrice,
        int $quantity,
        string $sku
    ): void {
        $this->items[] = Item::fromValues($name, $originalPrice, $quantity, $sku);
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => array_map(fn ($item) => $item->jsonSerialize(), $this->items)
        ];
    }
}
