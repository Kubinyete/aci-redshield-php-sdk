<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class Risk implements \JsonSerializable
{
    private array $parameters;

    public function __construct()
    {
        $this->parameters = [];
    }

    public function addUserData(string $value): void
    {
        $parametersCount = count($this->parameters) + 1;
        $this->parameters["USER_DATA_{$parametersCount}"] = substr($value, 0, 255);
    }

    public function jsonSerialize(): array
    {
        return $this->parameters;
    }
}
