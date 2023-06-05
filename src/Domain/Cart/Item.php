<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Cart;

use Jhernandes\AciRedShield\Domain\Shared\Decimal;

class Item implements \JsonSerializable
{
    private string $name;
    private Decimal $originalPrice;
    private int $quantity;
    private string $sku;

    public function __construct(
        string $name,
        float $originalPrice,
        int $quantity,
        string $sku
    ) {
        $this->ensureIsValidName($name);
        $this->name = $name;

        $this->originalPrice = Decimal::fromAmount($originalPrice);

        $this->ensureIsValidQuantity($quantity);
        $this->quantity = $quantity;

        $this->ensureIsValidSku($sku);
        $this->sku = $sku;
    }

    public static function fromValues(
        string $name,
        float $originalPrice,
        int $quantity,
        string $sku
    ): self {
        return new self($name, $originalPrice, $quantity, $sku);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'originalPrice' => (string)$this->originalPrice,
            'quantity' => $this->quantity,
            'sku' => $this->sku
        ];
    }

    private function ensureIsValidName(string $name): void
    {
        if (strlen($name) >= 65) {
            throw new \DomainException(
                sprintf('name must be lower than 65 characters long', $name)
            );
        }

        // $name = trim(preg_replace('/ +/', ' ', $name));
        // foreach (explode(' ', $name) as $singlename) {
        //     if (!preg_match('/^[0-9a-zA-ZÀ-ÖØ-öø-ÿ]+$/', $singlename)) {
        //         throw new \DomainException(
        //             sprintf('%s is not a valid name [0-9a-zA-ZÀ-ÖØ-öø-ÿ]', $name)
        //         );
        //     }
        // }
    }

    private function ensureIsValidQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \DomainException(
                sprintf('quantity must be higher than one', $quantity)
            );
        }
    }

    private function ensureIsValidSku(string $sku): void
    {
        if (strlen($sku) > 12) {
            throw new \DomainException(
                sprintf('%s sku must be lower than 13 characters long', $sku)
            );
        }

        // if (!preg_match('/^[0-9a-zA-Z_#]+$/', $sku)) {
        //     throw new \DomainException(
        //         sprintf('%s is not a valid sku [0-9a-zA-Z]', $sku)
        //     );
        // }
    }
}
