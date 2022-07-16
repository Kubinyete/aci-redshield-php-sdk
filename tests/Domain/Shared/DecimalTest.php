<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Shared\Decimal;

class DecimalTest extends TestCase
{
    public function testCanBeCreatedFromValidNumbers(): void
    {
        $this->assertInstanceOf(
            Decimal::class,
            Decimal::fromString('9,78')
        );

        $this->assertInstanceOf(
            Decimal::class,
            Decimal::fromString('2.12')
        );

        $this->assertInstanceOf(
            Decimal::class,
            Decimal::fromAmount(67.018389012390809123)
        );
    }

    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertSame(9.78, Decimal::fromString('9.780000000001')->amount());
    }

    public function testCanBeInstantiatedWithFourDecimalNumbers(): void
    {
        $decimal = new Decimal(19.78610000000000014, 4);

        $this->assertSame('19.7861', (string) $decimal);
    }

    public function testCanBeCreatedFromRangerOfNumber(): void
    {
        $floatNumber = 0.00;
        $intNumber = 0;
        while ($floatNumber <= 20.0) {
            $decimal = Decimal::fromAmount($floatNumber)->amount();

            $decimalInInt = (int) ((string) ($decimal * 100));

            $this->assertSame($intNumber, $decimalInInt);

            $floatNumber += 0.01;
            $intNumber += 1;
        }
    }

    public function testCanBeCreatedFromFloatOrString(): void
    {
        $floatNumber = 0.00;
        $intNumber = 0;
        while ($floatNumber <= 20.0) {
            $decimalFloat = Decimal::fromAmount($floatNumber)->amount();
            $decimalString = Decimal::fromString((string) $floatNumber)->amount();

            $this->assertSame($decimalFloat, $decimalString);

            $floatNumber += 0.01;
            $intNumber += 1;
        }
    }

    public function testCannotBeCreatedFromInvalidNumber(): void
    {
        $this->expectException(\DomainException::class);

        Decimal::fromString('12.A');
    }

    public function testCannotBeCreatedFromInvalidStringNumber(): void
    {
        $this->expectException(\DomainException::class);

        Decimal::fromString('NUMBER');
    }
}
