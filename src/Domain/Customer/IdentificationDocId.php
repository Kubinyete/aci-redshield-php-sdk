<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Customer;

use InvalidArgumentException;

class IdentificationDocId implements \JsonSerializable
{
    public const TAXSTATEMENT = 'TAXSTATEMENT';
    public const IDCARD = 'IDCARD';
    public const PASSPORT = 'PASSPORT';

    private string $identificationDocType;
    private string $identificationDocId;

    public function __construct(string $identificationDocId, string $identificationDocType)
    {
        $identificationDocId = mb_strcut(preg_replace('/[^a-zA-Z0-9]/', '', $identificationDocId), 0, 64);
        $this->guardAgainstInvalidDocumentNumber($identificationDocId);

        $this->identificationDocType = self::TAXSTATEMENT;
        $this->identificationDocId = $identificationDocId;
    }

    private function guardAgainstInvalidDocumentNumber(string $number): void
    {
        $length = mb_strlen($number);
        if ($length < 8 || $length > 64) throw new InvalidArgumentException("Identification number is expected to have a length between 8 and 64 characters");
    }

    public static function fromString(string $identificationDocId, string $identificationDocType = self::TAXSTATEMENT): self
    {
        return new self($identificationDocId, $identificationDocType);
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
}
