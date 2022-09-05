<?php

declare(strict_types=1);

use Jhernandes\AciRedShield\Application\Http\LoggerInterface;
use Jhernandes\AciRedShield\Application\Http\Request;
use PHPUnit\Framework\TestCase;

class TestLogger implements LoggerInterface
{
    public bool $prepared;
    public bool $received;

    public function __construct()
    {
        $this->prepared = false;
        $this->received = false;
    }

    public function onRequestPrepared(string $method, string $url, ?array $body, ?array $headers): void
    {
        $this->prepared = true;
    }

    public function onResponseReceived(?string $body, int $statusCode): void
    {
        $this->received = true;
    }
}

class LoggingTest extends TestCase
{
    private const TEST_URL = '1.1.1.1';

    public function testCanAttachLogger(): void
    {
        $request = new Request($logger = new TestLogger());
        $request->get(self::TEST_URL);

        $this->assertTrue($logger->prepared);
        $this->assertTrue($logger->received);
    }
}
