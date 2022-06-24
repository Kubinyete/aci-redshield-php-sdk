<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Risk;
use Jhernandes\AciRedShield\Domain\Order;
use Jhernandes\AciRedShield\Domain\Billing;
use Jhernandes\AciRedShield\Domain\Shipping;
use Jhernandes\AciRedShield\Domain\Card\Card;

class OrderTest extends TestCase
{
    private Order $order;

    public function setUp(): void
    {
        $this->order = Order::fromValues('123456', 169.78, 'visa');
    }

    public function testCanBeCreatedFromValidValues(): void
    {
        $this->assertInstanceOf(
            Order::class,
            $this->order
        );
    }

    public function testCanAddCard(): void
    {
        $this->order->addCard(Card::fromValues(
            'holder name',
            '4111 1111 1111 1111',
            '03',
            '2027'
        ));

        $this->assertArrayHasKey('card', $this->order->jsonSerialize());
    }

    public function testCanAddShipping(): void
    {
        $this->order->addShipping(
            Shipping::fromValues('01156060', 'Rua de Testes, 100', 'Bairro', 'Apto 100', 'São Paulo', 'SP')
        );

        $this->assertArrayHasKey('shipping', $this->order->jsonSerialize());
    }

    public function testCanAddBilling(): void
    {
        $this->order->addBilling(
            Billing::fromValues('01156060', 'Rua de Testes, 100', 'Bairro', 'Apto 100', 'São Paulo', 'SP')
        );

        $this->assertArrayHasKey('billing', $this->order->jsonSerialize());
    }

    public function testCanAddRisk(): void
    {
        $this->order->addRisk(Risk::fromList([
            'Rua Teste | 01156060',
            'user_data_2'
        ]));

        $this->assertArrayHasKey('risk', $this->order->jsonSerialize());
    }
}
