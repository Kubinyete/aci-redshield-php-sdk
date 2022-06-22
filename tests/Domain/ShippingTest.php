<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Shipping;
use Jhernandes\AciRedShield\Domain\Customer\Customer;

class ShippingTest extends TestCase
{
    public function testCanBeCreatedFromValidValues(): void
    {
        $this->assertInstanceOf(Shipping::class, Shipping::fromValues(
            '01156060',
            'Rua Júlio Gonzalez, 1000',
            'Barra Funda',
            '22 Andar, Sala 12',
            'São Paulo',
            'SP',
            'BR'
        ));
    }

    public function testCanInsertCustomer(): void
    {
        $shipping = Shipping::fromValues(
            '01156060',
            'Rua Júlio Gonzalez, 1000',
            'Barra Funda',
            '22 Andar, Sala 12',
            'São Paulo',
            'SP',
            'BR'
        );

        $shipping->addCustomer(Customer::fromValues('123456', 'JOSE ALBERTO SILVA', '12.345.678/0001-30'));

        $this->assertArrayHasKey('customer', $shipping->jsonSerialize());
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
        ], Shipping::fromValues(
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
