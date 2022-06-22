<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Shared;

class Postcode
{
    private string $postcode;

    public function __construct(string $postcode)
    {
        $postcode = preg_replace('/\D/', '', $postcode);

        $this->guardAgainstInvalidPostCode($postcode);

        $this->postcode = $postcode;
    }

    public static function fromString(string $postcode): self
    {
        return new self($postcode);
    }

    public function __toString(): string
    {
        return $this->postcode;
    }

    private function guardAgainstInvalidPostCode(string $postcode): void
    {
        if (!preg_match('/^[0-9]{8,10}$/', $postcode)) {
            throw new \UnexpectedValueException(
                sprintf('Not a valid postcode number: %s', $postcode)
            );
        }
    }
}
