<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Shared;

class Decimal
{
    private float $value;
    private int $decimals;

    public function __construct(float $value, int $decimals = 2)
    {
        $this->value = $value;
        $this->decimals = $decimals;
    }

    public static function fromAmount(float $value): self
    {
        return new self($value);
    }

    public static function fromString(string $number): self
    {
        $number = self::hasDecimalCommaSeparetor($number);

        if (!is_numeric($number)) {
            throw new \UnexpectedValueException(
                sprintf('%s is not a valid number', $number)
            );
        }

        return new self((float) $number);
    }

    public function __toString()
    {
        return (string) $this->formatted();
    }

    public function amount(): float
    {
        return round($this->value, $this->decimals);
    }

    private function formatted(): string
    {
        return number_format($this->value, $this->decimals, '.', '');
    }

    private static function hasDecimalCommaSeparetor(string $value): string
    {
        if (empty($value)) {
            return '0.0';
        }

        if (strpos($value, ',') !== false) {
            $value = str_replace(',', '.', $value);
        }

        return $value;
    }

    private static function normalize(float $value, int $decimals): float
    {
        $value = number_format($value, $decimals, '.', '');

        $valueFloor = floor($value * 100) / 100;
        $valueCeil = ceil($value * 100) / 100;

        if (hash_equals(md5((string) $value), md5((string) $valueFloor))) {
            $value = $valueFloor;
        } else {
            $value = $valueCeil;
        }

        return (float) number_format($value, $decimals, '.', '');
    }
}
