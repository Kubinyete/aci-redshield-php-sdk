<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Card;

class HolderName implements \Stringable
{
    private string $holder;

    public function __construct(string $holder)
    {
        $holder = $this->sanitize($holder);

        $this->ensureIsValidHolder($holder);

        $this->holder = strtoupper($holder);
    }

    public static function fromString(string $holder): self
    {
        return new self($holder);
    }

    public function __toString(): string
    {
        return $this->holder;
    }

    private function sanitize(string $holder): string
    {
        return trim($holder);
    }

    private function ensureIsValidHolder(string $holder): void
    {
        $holderNames = explode(' ', $holder);
        if (count($holderNames) <= 1) {
            throw new \DomainException(
                sprintf('%s must have at least first and one lastname', $holder)
            );
        }

        foreach ($holderNames as $singlename) {
            if (!preg_match('/^[a-zA-Z]+$/', $singlename)) {
                throw new \DomainException(
                    sprintf('%s is not a valid holder', $holder)
                );
            }
        }
    }
}
