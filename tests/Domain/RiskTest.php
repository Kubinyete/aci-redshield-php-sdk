<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Domain\Risk;
use PHPUnit\Framework\TestCase;

class RiskTest extends TestCase
{
    public function testCanCreateFromValidList(): void
    {
        $this->assertInstanceOf(
            Risk::class,
            Risk::fromList(['item1', 'item2'])
        );
    }

    public function testRiskListIsCountable(): void
    {
        $this->assertCount(2, Risk::fromList(['item1', 'item2']));
    }
}
