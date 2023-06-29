<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Card;

class CardNumber implements \Stringable
{
    private string $number;

    public function __construct(string $number)
    {
        $number = $this->sanitize($number);
        // $this->ensureIsValidLuhn($number);
        $this->number = $number;
    }

    public static function fromString(string $number): self
    {
        return new self($number);
    }

    public function __toString(): string
    {
        return $this->number;
    }

    private function sanitize(string $number): string
    {
        return preg_replace('/\D/', '', $number);
    }

    private function ensureIsValidLuhn(string $number): void
    {
        $parity = strlen($number) % 2;
        $total = 0;

        $digits = str_split($number);
        foreach ($digits as $key => $digit) {
            $digit = (int) $digit;
            if (($key % 2) == $parity) {
                $digit = ($digit * 2);
            }

            if ($digit >= 10) {
                $digit_parts = str_split((string) $digit);
                $digit = $digit_parts[0] + $digit_parts[1];
            }
            $total += $digit;
        }

        if ($total % 10 !== 0) {
            throw new \DomainException(
                sprintf('%s is not a valid card number', $number)
            );
        }
    }
}
