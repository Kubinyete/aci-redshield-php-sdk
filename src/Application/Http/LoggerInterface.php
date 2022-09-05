<?php

namespace Jhernandes\AciRedShield\Application\Http;

interface LoggerInterface
{
    function onRequestPrepared(string $method, string $url, ?array $body, ?array $headers): void;
    function onResponseReceived(?string $body, int $statusCode): void;
}
