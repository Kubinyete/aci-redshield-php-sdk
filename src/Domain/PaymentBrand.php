<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class PaymentBrand
{
    private const VISA = 'visa';
    private const MASTER = 'master';
    private const ELO = 'elo';
    private const AMEX = 'amex';
    private const HIPERCARD = 'hipercard';
    private const BOLETO = 'boleto';
    private const PIX = 'pix';
    private const DINERS = 'diners';
    private const DISCOVER = 'discover';
    private const JCB = 'jcb';
    private const CABAL = 'cabal';
    private const VISAELECTRON = 'visaelectron';
    private const MAESTRO = 'maestro';

    private string $paymentBrand;

    public function __construct(string $paymentBrand)
    {
        $this->guardAgainstInvalidPaymentBrand($paymentBrand);

        $this->paymentBrand = $paymentBrand;
    }

    public static function fromString(string $paymentBrand): self
    {
        return new self($paymentBrand);
    }

    public function __toString(): string
    {
        return strtoupper($this->paymentBrand);
    }

    private function guardAgainstInvalidPaymentBrand(string $paymentBrand): void
    {
        if (!in_array(strtolower($paymentBrand), $this->brands())) {
            throw new \UnexpectedValueException(
                sprintf('%s is not valid PaymentBrand', $paymentBrand)
            );
        }
    }

    private function brands(): array
    {
        return [
            self::VISA,
            self::MASTER,
            self::ELO,
            self::AMEX,
            self::HIPERCARD,
            self::BOLETO,
            self::PIX,
            self::DINERS,
            self::DISCOVER,
            self::JCB,
            self::CABAL,
            self::VISAELECTRON,
            self::MAESTRO,
        ];
    }
}
