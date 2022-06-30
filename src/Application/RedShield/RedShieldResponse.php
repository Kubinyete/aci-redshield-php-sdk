<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Application\RedShield;

use Psr\Http\Message\ResponseInterface;

class RedShieldResponse implements \JsonSerializable
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return new self($response);
    }

    public function jsonSerialize(): array
    {
        return [
            'code' => $this->response->getStatusCode(),
            'data' => $this->getBody()
        ];
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function getBody(): array
    {
        $body = $this->response->getBody();

        return json_decode((string) $body, true);
    }
}
