<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Customer;

class Status
{
    private const NEW = 'NEW';
    private const EXISTING = 'EXISTING';

    private string $status;

    public function __construct(string $status)
    {
        $this->status = in_array($status, [self::NEW, self::EXISTING]) ? $status : self::NEW;
    }

    public static function fromString(string $status): self
    {
        return new self($status);
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
