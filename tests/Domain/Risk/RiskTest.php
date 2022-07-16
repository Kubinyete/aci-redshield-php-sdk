<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Risk\Risk;

class RiskTest extends TestCase
{
    private const CHANNELID = '000668000001';
    private const SERVICEID = 'I';

    public function testCanCreateFromValidList(): void
    {
        $this->assertInstanceOf(
            Risk::class,
            Risk::fromValues(self::CHANNELID, self::SERVICEID, ['item1', 'item2'])
        );
    }

    public function testCanCreateWithEmptyUserDataAndAddNewUserData(): void
    {
        $risk = Risk::fromValues(self::CHANNELID, self::SERVICEID, []);
        $risk->addUserData('user_data_1');
        $risk->addUserData('user_data_2');
        $risk->addUserData('user_data_3');

        $this->assertCount(5, $risk->jsonSerialize());
    }
}
