<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

class Risk implements \JsonSerializable, \Countable
{
    private array $parameters;

    public function __construct()
    {
        $this->parameters = [];
    }

    public static function fromList(array $list): self
    {
        $risk = new self();
        foreach ($list as $value) {
            $risk->addUserData($value);
        }
        return $risk;
    }

    public function count(): int
    {
        return count($this->parameters);
    }

    public function addUserData(string $value): void
    {
        $parametersCount = $this->count() + 1;
        $this->parameters["parameters[USER_DATA{$parametersCount}]"] = substr($value, 0, 255);
    }

    public function jsonSerialize(): array
    {
        return $this->parameters;
    }
}
