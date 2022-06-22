<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

use PHPUnit\Framework\Constraint\Count;
use Jhernandes\AciRedShield\Domain\Shared\Country;
use Jhernandes\AciRedShield\Domain\Shared\Postcode;

class Merchant implements \JsonSerializable
{
    public const COUNTRY_BRAZIL = 'BR';

    private ?string $entityId;
    private Postcode $postcode;
    private Country $country;
    private string $mcc;

    public function __construct(
        string $postcode,
        string $mcc,
        ?string $country = self::COUNTRY_BRAZIL,
        ?string $entityId = null
    ) {
        $this->entityId = $entityId;
        $this->country = Country::fromAlpha2($country);
        $this->postcode = Postcode::fromString($postcode);
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
            'postcode' => (string) $this->postcode,
            'country' => (string) $this->country,
            'mcc' => $this->mcc,
        ];

        if ($this->entityId !== null) {
            $merchant['entityID'] = $this->entityId;
        }

        return $merchant;
    }
}
