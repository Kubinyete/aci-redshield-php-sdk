<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Customer;

class IdentificationDocId implements \JsonSerializable
{
    private const DOC_TYPE = 'TAXSTATEMENT';

    private string $identificationDocType;
    private string $identificationDocId;

    public function __construct(string $identificationDocId)
    {
        $identificationDocId = preg_replace('/\D/', '', $identificationDocId);

        $this->guardAgainstFromInvalidIdentificationDocId($identificationDocId);

        $this->identificationDocType = self::DOC_TYPE;
        $this->identificationDocId = preg_replace('/\D/', '', $identificationDocId);
    }

    public static function fromString(string $identificationDocId): self
    {
        return new self($identificationDocId);
    }

    public function docType(): string
    {
        return $this->identificationDocType;
    }

    public function docId(): string
    {
        return $this->identificationDocId;
    }

    public function jsonSerialize(): array
    {
        return [
            'identificationDocType' => $this->identificationDocType,
            'identificationDocId' => $this->identificationDocId,
        ];
    }

    private function guardAgainstFromInvalidIdentificationDocId(string $identificationDocId): void
    {
        if (!preg_match('/^[0-9]{11,14}$/', $identificationDocId)) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid identificationDocId. [0-9a-zA-Z]{11,14}', $identificationDocId)
            );
        }
    }
}
