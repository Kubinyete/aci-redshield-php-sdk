<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Shared\Country;

class CountryTest extends TestCase
{
    public function testCanBeCreatedFromValidIso3166CountryCode()
    {
        $this->assertSame(
            'BR',
            (string) Country::fromAlpha2('br')
        );
    }

    public function testCannotBeCreatedFromInvalidIso3166CountryCode()
    {
        $this->expectException(\UnexpectedValueException::class);

        Country::fromAlpha2("BRA");
    }
}
