<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class Merchant implements \JsonSerializable
{
    public const COUNTRY_BRAZIL = 'BR';

    private ?string $entityId;
    private string $postcode;
    private string $country;
    private string $mcc;

    public function __construct(
        string $postcode,
        string $mcc,
        ?string $country = self::COUNTRY_BRAZIL,
        ?string $entityId = null
    ) {
        $this->entityId = $entityId;
        $this->country = $country;
        $this->postcode = substr(trim($postcode), 0, 10);
        $this->mcc = substr(preg_replace('/\D/', '', $mcc), 0, 4);
    }

    public static function fromValues(string $postcode, string $mcc): self
    {
        return new self($postcode, $mcc);
    }

    public function setEntityId(string $entityId): void
    {
        $this->entityId = substr(trim($entityId), 0, 32);
    }

    public function jsonSerialize(): array
    {
        $merchant = [
            'postcode' => $this->postcode,
            'country' => $this->country,
            'mcc' => $this->mcc,
        ];

        if ($this->entityId !== null) {
            $merchant['entityID'] = $this->entityId;
        }

        return $merchant;
    }
}
