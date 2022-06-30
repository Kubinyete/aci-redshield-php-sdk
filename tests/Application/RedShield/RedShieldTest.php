<?php

declare(strict_types=1);

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Risk;
use Jhernandes\AciRedShield\Domain\Order;
use Jhernandes\AciRedShield\Domain\Billing;
use Jhernandes\AciRedShield\Domain\Shipping;
use Jhernandes\AciRedShield\Domain\Card\Card;
use Jhernandes\AciRedShield\Domain\Cart\Cart;
use Jhernandes\AciRedShield\Domain\Cart\Item;
use Jhernandes\AciRedShield\Domain\Customer\Customer;
use Jhernandes\AciRedShield\Application\Helpers\ArrayHelper;
use Jhernandes\AciRedShield\Application\RedShield\RedShield;
use Jhernandes\AciRedShield\Application\RedShield\RedShieldResponse;

class RedShieldTest extends TestCase
{
    public function testCanAccessEnvironmentVariables(): void
    {
        $this->assertNotEmpty(getenv('TOKEN'));
    }

    public function testCanRegisterWithSuccess(): void
    {
        $faker = Faker\Factory::create('pt_BR');

        $customerName = preg_replace('/[^a-zA-Z0-9 ]+/', '', $faker->firstName . ' ' . $faker->lastName);
        $order = Order::fromValues(
            getenv('ENTITYID'),
            (string) $faker->numberBetween(1000000, 9999999),
            $faker->randomFloat(2, 1, 200),
            strtolower($faker->creditCardType),
        );

        $order->addCard(Card::fromValues(
            $customerName,
            (string) $faker->creditCardNumber,
            (string) $faker->numberBetween(1, 12),
            (string) $faker->numberBetween(2023, 2029)
        ));

        $customer = Customer::fromValues(
            (string) $faker->numberBetween(40000, 100000),
            $customerName,
            $faker->cpf
        );
        $customer->setBirthdate($faker->date('Y-m-d', '1999-12-31'));
        $customer->setEmail('accept@test.com');
        $customer->setPhone($faker->phoneNumber);
        $customer->setIp($faker->ipv4);

        $order->addCustomer($customer);

        $order->addBilling(Billing::fromValues(
            $faker->postcode,
            $faker->streetAddress,
            $faker->secondaryAddress,
            $faker->buildingNumber,
            preg_replace('/[^a-zA-Z0-9 ]+/', '', $faker->city),
            $faker->stateAbbr
        ));

        $shipping = Shipping::fromValues(
            $faker->postcode,
            $faker->streetAddress,
            $faker->secondaryAddress,
            $faker->buildingNumber,
            preg_replace('/[^a-zA-Z0-9 ]+/', '', $faker->city),
            $faker->stateAbbr
        );
        $shipping->addCustomer($customer);

        $order->addShipping($shipping);

        $order->addCart(Cart::fromItems(
            Item::fromValues($faker->word, $faker->randomFloat(2, 1, 200), 1, $faker->isbn10),
            Item::fromValues($faker->word, $faker->randomFloat(2, 1, 200), 1, $faker->isbn10),
            Item::fromValues($faker->word, $faker->randomFloat(2, 1, 200), 1, $faker->isbn10),
            Item::fromValues($faker->word, $faker->randomFloat(2, 1, 200), 1, $faker->isbn10),
        ));

        $order->addRisk(Risk::fromList([
            sprintf('%s|%s', $faker->streetAddress, $faker->postcode)
        ]));

        $redShield = new RedShield('test', getenv('TOKEN'));
        $response = $redShield->register($order);

        $this->assertInstanceOf(RedShieldResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('000.300.100', $response->getBody()['result']['code']);
    }
}
