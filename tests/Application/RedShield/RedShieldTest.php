<?php

declare(strict_types=1);

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Order;
use Jhernandes\AciRedShield\Domain\Billing;
use Jhernandes\AciRedShield\Domain\Shipping;
use Jhernandes\AciRedShield\Domain\Card\Card;
use Jhernandes\AciRedShield\Domain\Cart\Cart;
use Jhernandes\AciRedShield\Domain\Cart\Item;
use Jhernandes\AciRedShield\Domain\Risk\Risk;
use Jhernandes\AciRedShield\Domain\Customer\Customer;
use Jhernandes\AciRedShield\Application\Helpers\ArrayHelper;
use Jhernandes\AciRedShield\Application\RedShield\RedShield;
use Jhernandes\AciRedShield\Application\RedShield\RedShieldResponse;

class RedShieldTest extends TestCase
{
    private const CHANNELID = '000668000001';
    private const SERVICEID = 'I';

    public function testCanAccessEnvironmentVariables(): void
    {
        $this->assertNotEmpty(getenv('TOKEN'));
    }

    public function testCanRegisterWithSuccess(): void
    {
        $faker = Faker\Factory::create('pt_BR');

        $customerName = preg_replace('/[^a-zA-Z0-9 ]+/', '', $faker->firstName . ' ' . $faker->lastName);
        $orderAmount = $faker->randomFloat(2, 1, 2000);

        $order = Order::fromValues(
            getenv('ENTITYID'),
            (string) $faker->numberBetween(1000000, 9999999),
            $orderAmount,
            strtolower($this->creditCard()['brand']),
        );

        $order->addCard(Card::fromValues(
            $customerName,
            (string) $this->creditCard()['number'],
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
        $customer->setStatus('EXISTING');

        $order->addCustomer($customer);
        $billingAddress = [
            'postcode' => $faker->postcode,
            'street1' => $faker->streetAddress,
            'street2' => $faker->secondaryAddress,
            'buildingNumber' => $faker->buildingNumber,
            'city' => preg_replace('/[^a-zA-Z0-9 ]+/', '', $faker->city),
            'state' => $faker->stateAbbr,
        ];

        $order->addBilling(Billing::fromValues(
            $billingAddress['postcode'],
            $billingAddress['street1'],
            $billingAddress['street2'],
            $billingAddress['buildingNumber'],
            $billingAddress['city'],
            $billingAddress['state'],
        ));

        $shippingAddress = [
            'postcode' => $faker->postcode,
            'street1' => $faker->streetAddress,
            'street2' => $faker->secondaryAddress,
            'buildingNumber' => $faker->buildingNumber,
            'city' => preg_replace('/[^a-zA-Z0-9 ]+/', '', $faker->city),
            'state' => $faker->stateAbbr,
        ];

        $shipping = Shipping::fromValues(
            $shippingAddress['postcode'],
            $shippingAddress['street1'],
            $shippingAddress['street2'],
            $shippingAddress['buildingNumber'],
            $shippingAddress['city'],
            $shippingAddress['state'],
        );
        $shipping->addCustomer($customer);

        $order->addShipping($shipping);

        $order->addCart(Cart::fromItems(
            Item::fromValues($faker->word, $orderAmount / 2, 1, $faker->isbn10),
            Item::fromValues($faker->word, $orderAmount / 2, 1, $faker->isbn10),
        ));
        $risk = Risk::fromValues(self::CHANNELID, self::SERVICEID, [
            sprintf('%s|%s', $billingAddress['street1'], $billingAddress['postcode']),
            sprintf('%s|%s', $shippingAddress['street1'], $shippingAddress['postcode']),
        ]);
        $risk->addTimeOnFile($customerOnBaseInDays = 356);
        $order->addRisk($risk);

        $redShield = new RedShield('test', getenv('TOKEN'));

        $response = $redShield->register($order);

        $this->assertInstanceOf(RedShieldResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('000.300.100', $response->getBody()['result']['code']);
    }

    private function creditCard(): array
    {
        return [
            'brand' => 'MASTER',
            'number' => '5185 6677 8468 8345',
        ];
    }
}
