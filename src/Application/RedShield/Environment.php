<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Application\RedShield;

class Environment
{
    private const TEST = 'https://eu-test.oppwa.com/v2/redShield';
    private const PRODUCTION = 'https://eu-prod.oppwa.com/v2/redShield';

    private string $environment;

    public function __construct(string $environment)
    {
        $this->environment = ($environment !== 'production') ? 'test' : 'production';
    }

    public static function fromString(string $environment): self
    {
        return new self($environment);
    }

    public function isProduction(): bool
    {
        return !!($this->environment === 'production');
    }

    public function url(): string
    {
        if ($this->isProduction()) {
            return self::PRODUCTION;
        }
        return self::TEST;
    }
}
