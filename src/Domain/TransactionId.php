<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class TransactionId implements \Stringable
{
    private string $transactionId;

    public function __construct(string $transactionId)
    {
        $this->guardAgainstInvalidTransactionId($transactionId);

        $this->transactionId = $transactionId;
    }

    public static function fromString(string $transactionId): self
    {
        return new self($transactionId);
    }

    public function __toString(): string
    {
        return $this->transactionId;
    }

    private function guardAgainstInvalidTransactionId(string $transactionId): void
    {
        if (!preg_match('/^[0-9]{1,40}$/', $transactionId)) {
            throw new \DomainException(
                sprintf('%s is not a valid TransactionId', $transactionId)
            );
        }
    }
}
