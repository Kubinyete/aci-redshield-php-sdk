<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\Merchant;
use PHPUnit\Framework\TestCase;

class MerchantTest extends TestCase
{
    public function testCanBeCreatedFromValidValues(): void
    {
        $this->assertInstanceOf(Merchant::class, Merchant::fromValues('01156060', '1234'));
    }

    public function testCanBeRepresentedAsArray(): void
    {
        $this->assertSame([
            'postcode' => '01156060',
            'country' => 'BR',
            'mcc' => '1234'
        ], Merchant::fromValues('01156060', '1234')->jsonSerialize());
    }

    public function testCanSetEntityIdAfterCreated(): void
    {
        $merchant = Merchant::fromValues('01156060', '1234');
        $entityId = hash('ripemd128', '123456');
        $merchant->setEntityId($entityId);

        $this->assertEquals($entityId, $merchant->jsonSerialize()['entityID']);
    }
}
