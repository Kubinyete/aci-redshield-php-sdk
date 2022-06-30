<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Application\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use Jhernandes\AciRedShield\Application\RedShield\Token;

class Request
{
    private Client $httpClient;
    private string $token;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function setBearerToken(string $token): void
    {
        $this->token = (string) Token::fromString($token);
    }

    public function post(string $url, array $data): ResponseInterface
    {
        try {
            $response = $this->httpClient->request('POST', $url, [
                'form_params'    => $data,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$this->token}"
                ],
            ]);

            return $response;
        } catch (BadResponseException $e) {
            return $e->getResponse();
        }
    }

    public function get(string $url): ResponseInterface
    {
        try {
            $response = $this->httpClient->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$this->token}"
                ],
            ]);

            return $response;
        } catch (BadResponseException $e) {
            return $e->getResponse();
        }
    }
}
