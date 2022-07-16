<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Risk\Parameters;

class ParametersTest extends TestCase
{
    private Parameters $parameters;

    public function setup(): void
    {
        $this->parameters = Parameters::fromList([
            'user_data_1',
            'user_data_2',
            'user_data_3',
        ]);
    }

    public function testCanBeCreatedFromAList(): void
    {
        $this->assertInstanceOf(Parameters::class, $this->parameters);
    }

    public function testCanAddTimeOnFile(): void
    {
        $parameters = clone $this->parameters;
        $parameters->addTimeOnFile(356);

        $this->assertArrayHasKey('parameters[TimeOnFile]', $parameters->jsonSerialize());
    }

    public function testCanBeCount(): void
    {
        $this->assertCount(3, $this->parameters);
    }

    public function testCanBeJsonSerialized(): void
    {
        $this->assertJson(json_encode($this->parameters));
    }

    public function testCanBeIterated(): void
    {
        $this->assertIsIterable($this->parameters);
    }
}
