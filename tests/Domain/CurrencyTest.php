<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\Shared\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testCanBeCreatedFromValidCurrencyIsoAlpha3(): void
    {
        $this->assertInstanceOf(Currency::class, Currency::fromAlpha3('brl'));
    }

    public function testIsRepresentedAsUppercase(): void
    {
        $this->assertSame('BRL', (string) Currency::fromAlpha3('brl'));
    }

    public function testCannotBeCreatedFromInvalidIsoAlpha3(): void
    {
        $this->expectException(\DomainException::class);

        Currency::fromAlpha3('123');
    }
}
