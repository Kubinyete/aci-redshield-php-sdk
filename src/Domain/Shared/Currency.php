<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Shared;

class Currency implements \Stringable
{
    private string $currency;

    public function __construct(string $currency)
    {
        $currency = strtoupper($currency);

        $this->guardAgainstInvalidAlpha3($currency);

        $this->currency = $currency;
    }

    public static function fromAlpha3(string $string): self
    {
        return new self($string);
    }

    public function __toString(): string
    {
        return $this->currency;
    }

    private function guardAgainstInvalidAlpha3(string $alpha3): void
    {
        if (!preg_match('/^[A-Z]{3}$/', $alpha3)) {
            throw new \DomainException(
                sprintf('%s is not a valid ISO 3-digit alpha currency code', $alpha3)
            );
        }
    }
}
