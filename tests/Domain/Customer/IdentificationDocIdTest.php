<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Customer\IdentificationDocId;

class IdentificationDocIdTest extends TestCase
{
    public function testCanBeCreatedFromValidCpf()
    {
        $this->assertInstanceOf(
            IdentificationDocId::class,
            IdentificationDocId::fromString('799.993.388-01')
        );
    }

    public function testCanBeCreatedFromValidCnpj()
    {
        $this->assertInstanceOf(
            IdentificationDocId::class,
            IdentificationDocId::fromString('12.321.123/0001-12')
        );
    }

    public function testCannotBeCreatedFromStringLesserThan11Characters()
    {
        $this->expectException(\UnexpectedValueException::class);
        IdentificationDocId::fromString('123456');
    }

    public function testCannotBeCreatedFromStringGreaterThan13Characters()
    {
        $this->expectException(\UnexpectedValueException::class);
        IdentificationDocId::fromString('123456123456123456');
    }
}
