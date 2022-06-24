<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\PaymentBrand;
use PHPUnit\Framework\TestCase;

class PaymentBrandTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(PaymentBrand::class, PaymentBrand::fromString('visa'));
    }

    public function testAssertAllBrandsAreValid(): void
    {
        $this->assertEquals([
            'VISA',
            'MASTER',
            'ELO',
            'AMEX',
            'HIPERCARD',
            'DINERS',
            'DISCOVER',
            'JCB',
            'CABAL',
            'VISAELECTRON',
            'MAESTRO',
            'BOLETO',
            'PIX',
        ], [
            (string) PaymentBrand::fromString('visa'),
            (string) PaymentBrand::fromString('master'),
            (string) PaymentBrand::fromString('elo'),
            (string) PaymentBrand::fromString('amex'),
            (string) PaymentBrand::fromString('hipercard'),
            (string) PaymentBrand::fromString('diners'),
            (string) PaymentBrand::fromString('discover'),
            (string) PaymentBrand::fromString('jcb'),
            (string) PaymentBrand::fromString('cabal'),
            (string) PaymentBrand::fromString('visaelectron'),
            (string) PaymentBrand::fromString('maestro'),
            (string) PaymentBrand::fromString('boleto'),
            (string) PaymentBrand::fromString('pix'),
        ]);
    }

    public function testCannotBeCreatedFromInvalidString(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        PaymentBrand::fromString('NOT A VALID PAYMENT');
    }
}
