<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class EntityId
{
    private string $entityId;

    public function __construct(string $entityId)
    {
        $this->guardAgainsInvalidEntityId($entityId);

        $this->entityId = $entityId;
    }

    public static function fromString(string $entityId): self
    {
        return new self($entityId);
    }

    public function __toString(): string
    {
        return $this->entityId;
    }

    private function guardAgainsInvalidEntityId(string $entityId): void
    {
        if (!preg_match('/^[0-9a-zA-Z]{32}$/', $entityId)) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid EntityId', $entityId),
            );
        }
    }
}
