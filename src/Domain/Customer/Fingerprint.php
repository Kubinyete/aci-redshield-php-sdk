<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Customer;

class Fingerprint implements \Stringable
{
    private string $fingerprint;

    public function __construct(string $fingerprint)
    {
        $this->guardAgainstInvalidFingerprint($fingerprint);

        $this->fingerprint = $fingerprint;
    }

    public static function fromString(string $fingerprint): self
    {
        return new self($fingerprint);
    }

    public function __toString(): string
    {
        return $this->fingerprint;
    }

    public function guardAgainstInvalidFingerprint(string $fingerprint): void
    {
        if (strlen($fingerprint) < 1 || strlen($fingerprint) > 4000) {
            throw new \DomainException(
                sprintf('%s is not a valid fingerprintf', $fingerprint)
            );
        }
    }
}
