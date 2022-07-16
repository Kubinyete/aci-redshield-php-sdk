<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Customer;

class CustomerId implements \Stringable
{
    private string $customerId;

    public function __construct(string $customerId)
    {
        $this->guardAgainstInvalidCustomerId($customerId);

        $this->customerId = $customerId;
    }

    public static function fromString(string $customerId): self
    {
        return new self($customerId);
    }

    public function __toString(): string
    {
        return $this->customerId;
    }

    private function guardAgainstInvalidCustomerId(string $customerId): void
    {
        if (!preg_match('/^[0-9a-zA-Z]{1,32}$/', $customerId)) {
            throw new \DomainException(
                sprintf('%s is not a valid customerId. [0-9a-zA-Z]{1,32}', $customerId)
            );
        }
    }
}
