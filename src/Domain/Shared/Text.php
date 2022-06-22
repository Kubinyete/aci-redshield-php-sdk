<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Shared;

class Text
{
    private string $text;
    private int $maxLength;

    public function __construct(string $text, int $maxLength = 255, bool $blank = false)
    {
        $this->ensureIsNotBlank($text, $blank);
        $this->ensureIsValidText($text);
        $this->text = $text;

        $this->ensureMaxLengthHasMinimumSize($maxLength);
        $this->maxLength = $maxLength;
    }

    public static function fromString(string $text, int $maxLength = 255): self
    {
        return new self($text, $maxLength);
    }

    public function length(): int
    {
        return strlen((string) $this);
    }

    public function __toString(): string
    {
        return substr(trim($this->text), 0, $this->maxLength);
    }

    private function ensureMaxLengthHasMinimumSize(int $maxLength): void
    {
        if ($maxLength <= 0) {
            throw new \UnexpectedValueException('maxLength must be at least 1.');
        }
    }

    private function ensureIsNotBlank(string $text, bool $blank): void
    {
        if (!$blank && empty($text)) {
            throw new \UnexpectedValueException(sprintf('%s cannot be blank.', $text));
        }
    }

    private function ensureIsValidText(string $text): void
    {
        foreach (explode(' ', $text) as $string) {
            if (!preg_match('/^[0-9a-zA-ZÀ-ÖØ-öø-ÿ,.]+$/', $string)) {
                throw new \UnexpectedValueException(
                    sprintf('%s is not a valid text', $text)
                );
            }
        }
    }
}
