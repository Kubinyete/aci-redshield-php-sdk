<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Shared\Text;

class TextTest extends TestCase
{
    public function testCanBeCreatedFromValidString()
    {
        $text = 'Rua Barão do Rio Branco, 345';
        $this->assertSame(
            $text,
            (string) Text::fromString($text, 30)
        );
    }

    public function testCanBeRepresentedAsMaxLengthSize(): void
    {
        $this->assertEquals(
            10,
            Text::fromString('This text has more than 10 characters.', 10)->length()
        );
    }

    public function testCannotBeCreatedFromInvalidText(): void
    {
        $this->expectExceptionMessage('is not a valid text');
        $this->expectException(\DomainException::class);

        Text::fromString('Rua %ˆTeste//De//Txto', 200);
    }

    public function testCannotBeCreatedFromEmptyText(): void
    {
        $this->expectExceptionMessage('cannot be blank');
        $this->expectException(\DomainException::class);

        Text::fromString('', 10);
    }

    public function testCannotBeCreatedWithLessThanOneMaxLength()
    {
        $this->expectExceptionMessage('maxLength must be at least 1');
        $this->expectException(\DomainException::class);

        Text::fromString('Texto Simples', 0);
    }
}
