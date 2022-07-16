<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Card;

use Jhernandes\AciRedShield\Domain\Card\CardNumber;
use Jhernandes\AciRedShield\Domain\Card\HolderName;

class Card implements \JsonSerializable
{
    private HolderName $holder;
    private CardNumber $number;
    private string $expiryMonth;
    private string $expiryYear;

    public function __construct(
        string $holder,
        string $number,
        string $expiryMonth,
        string $expiryYear
    ) {
        $this->holder = HolderName::fromString($holder);
        $this->number = CardNumber::fromString($number);

        $this->ensureIsValidExpiryMonth($expiryMonth);
        $this->expiryMonth = sprintf("%02d", $expiryMonth);

        $this->ensureIsValidExpiryYear($expiryYear);
        $this->expiryYear = sprintf("%04d", $expiryYear);
    }

    public static function fromValues(
        string $holder,
        string $number,
        string $expiryMonth,
        string $expiryYear
    ): self {
        return new self($holder, $number, $expiryMonth, $expiryYear);
    }

    public function jsonSerialize(): array
    {
        return [
            'holder' => (string) $this->holder,
            'number' => (string) $this->number,
            'expiryMonth' => $this->expiryMonth,
            'expiryYear' => $this->expiryYear,
        ];
    }

    private function ensureIsValidExpiryMonth(string $month): void
    {
        $monthAsInt = (int) $month;
        if (!is_numeric($month) || $monthAsInt < 1 || $monthAsInt > 12) {
            throw new \DomainException(
                sprintf('%s is not valid expiry month', $month)
            );
        }
    }

    private function ensureIsValidExpiryYear(string $year): void
    {
        $yearAsInt = (int) $year;

        if (!preg_match("/^(\d{4})$/", $year)) {
            throw new \DomainException(
                sprintf('%s is not a valid expiry year format (YYYY)', $year)
            );
        }

        if (!is_numeric($year) || $yearAsInt < 2000) {
            throw new \DomainException(
                sprintf('%s is not valid expiry year', $year)
            );
        }
    }
}
