<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class Country
{
    private string $country;

    public function __construct(string $country)
    {
        $this->guardAgainstInvalidAlpha2($country);

        $this->country = $country;
    }

    public static function fromAlpha2(string $string): self
    {
        return new self($string);
    }

    public function __toString(): string
    {
        return strtoupper($this->country);
    }

    private function guardAgainstInvalidAlpha2(string $alpha2): void
    {
        if (!preg_match('/^[a-zA-Z]{2}$/', $alpha2)) {
            throw new \UnexpectedValueException(
                sprintf('Not a valid alpha2 key: %s', $alpha2)
            );
        }
    }
}
