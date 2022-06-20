<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\Billing;
use PHPUnit\Framework\TestCase;

class BillingTest extends TestCase
{
    public function testCanBeCreatedFromValidValues(): void
    {
        $this->assertInstanceOf(Billing::class, Billing::fromValues(
            '01156060',
            'Rua Júlio Gonzalez, 1000',
            'Barra Funda',
            '22 Andar, Sala 12',
            'São Paulo',
            'SP',
            'BR'
        ));
    }

    public function testCanBeRepresentedAsArray(): void
    {
        $this->assertSame([
            'houseNumber1' => '22 Andar, Sala 12',
            'street1' => 'Rua Júlio Gonzalez, 1000',
            'street2' => 'Barra Funda',
            'city' => 'São Paulo',
            'state' => 'SP',
            'country' => 'BR',
            'postcode' => '01156060'
        ], Billing::fromValues(
            '01156060',
            'Rua Júlio Gonzalez, 1000',
            'Barra Funda',
            '22 Andar, Sala 12',
            'São Paulo',
            'SP',
            'BR'
        )->jsonSerialize());
    }
}
