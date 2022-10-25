<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Application\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use Jhernandes\AciRedShield\Application\RedShield\Token;
use RuntimeException;

class Request
{
    private Client $httpClient;
    private string $token;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->token = '';
    }

    public function setBearerToken(string $token): void
    {
        $this->token = (string) Token::fromString($token);
    }

    protected function request(string $method, string $url, ?array $data = null): ResponseInterface
    {
        $usingHeaders = ['Accept' => 'application/json',];
        $usingHeaders = array_merge($usingHeaders, $data ? ['Content-Type' => 'application/x-www-form-urlencoded'] : []);
        $usingHeaders = array_merge($usingHeaders, $this->token ? ['Authorization' => "Bearer {$this->token}"] : []);

        try {
            $response = $this->httpClient->request($method, $url, [
                'form_params' => $data,
                'headers' => $usingHeaders,
            ]);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    public function post(string $url, array $data): ResponseInterface
    {
        return $this->request('POST', $url, $data);
    }

    public function get(string $url): ResponseInterface
    {
        return $this->request('GET', $url);
    }
}
