<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

use Jhernandes\AciRedShield\Domain\Billing;
use Jhernandes\AciRedShield\Domain\Shipping;
use Jhernandes\AciRedShield\Domain\Card\Card;
use Jhernandes\AciRedShield\Domain\Cart\Cart;
use Jhernandes\AciRedShield\Domain\Risk\Risk;
use Jhernandes\AciRedShield\Domain\PaymentBrand;
use Jhernandes\AciRedShield\Domain\TransactionId;
use Jhernandes\AciRedShield\Domain\Shared\Decimal;
use Jhernandes\AciRedShield\Domain\Shared\Currency;
use Jhernandes\AciRedShield\Domain\Customer\Customer;

class Order implements \JsonSerializable
{
    private EntityId $entityId;
    private TransactionId $merchantTransactionId;
    private Decimal $amount;
    private Currency $currency;
    private PaymentBrand $paymentBrand;

    private Card $card;
    private Customer $customer;
    private Billing $billing;
    private Shipping $shipping;
    private Risk $risk;

    public function __construct(
        string $entityId,
        string $merchantTransactionId,
        float $amount,
        string $paymentBrand,
        string $currency = 'BRL'
    ) {
        $this->entityId = EntityId::fromString($entityId);
        $this->merchantTransactionId = TransactionId::fromString($merchantTransactionId);
        $this->amount = Decimal::fromAmount($amount);

        $this->paymentBrand = PaymentBrand::fromString($paymentBrand);
        $this->currency = Currency::fromAlpha3($currency);
    }

    public static function fromValues(
        string $entityId,
        string $merchantTransactionId,
        float $amount,
        string $paymentBrand,
        string $currency = 'BRL'
    ): self {
        return new self($entityId, $merchantTransactionId, $amount, $paymentBrand, $currency);
    }

    public function addCard(Card $card): void
    {
        $this->card = $card;
    }

    public function addCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function addCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function addBilling(Billing $billing): void
    {
        $this->billing = $billing;
    }

    public function addShipping(Shipping $shipping): void
    {
        $this->shipping = $shipping;
    }

    public function addRisk(Risk $risk): void
    {
        $this->risk = $risk;
    }

    public function jsonSerialize(): array
    {
        $order = [
            'entityId' => (string) $this->entityId,
            'merchantTransactionId' => (string) $this->merchantTransactionId,
            'amount' => $this->amount->amount(),
            'currency' => (string) $this->currency,
            'paymentBrand' => (string) $this->paymentBrand,
        ];

        if (isset($this->card)) {
            $order['card'] = $this->card->jsonSerialize();
        }

        if (isset($this->cart)) {
            $order['cart'] = $this->cart->jsonSerialize();
        }

        if (isset($this->customer)) {
            $order['customer'] = $this->customer->jsonSerialize();
        }

        if (isset($this->billing)) {
            $order['billing'] = $this->billing->jsonSerialize();
        }

        if (isset($this->shipping)) {
            $order['shipping'] = $this->shipping->jsonSerialize();
        }

        if (isset($this->risk)) {
            $order['risk'] = $this->risk->jsonSerialize();
        }

        return $order;
    }
}
