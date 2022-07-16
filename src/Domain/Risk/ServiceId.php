<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Risk;

class ServiceId implements \Stringable
{
    private string $serviceId;

    public function __construct(string $serviceId)
    {
        $this->guardAgainsInvalidServiceId($serviceId);

        $this->serviceId = $serviceId;
    }

    public static function fromString(string $serviceId): self
    {
        return new self($serviceId);
    }

    public function __toString(): string
    {
        return $this->serviceId;
    }

    private function guardAgainsInvalidServiceId(string $serviceId): void
    {
        if (strlen($serviceId) !== 1) {
            throw new \DomainException(
                sprintf('A serviceId must have only one character.', $serviceId)
            );
        }
    }
}
