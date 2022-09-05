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
    private ?LoggerInterface $requestLogger;
    private string $token;

    public function __construct(?LoggerInterface $requestAwareLogger = null)
    {
        $this->httpClient = new Client();
        $this->token = '';
        $this->requestLogger = $requestAwareLogger;
    }

    public function setBearerToken(string $token): void
    {
        $this->token = (string) Token::fromString($token);
    }

    public function setLogger(?LoggerInterface $logger): void
    {
        $this->requestLogger = $logger;
    }

    protected function canLogRequests(): bool
    {
        return !is_null($this->requestLogger);
    }

    protected function shouldLogRequest(string $method, string $url, ?array $data, ?array $headers): void
    {
        if ($this->canLogRequests()) {
            $this->requestLogger->onRequestPrepared($method, $url, $data, $headers);
        }
    }

    protected function shouldLogResponse(ResponseInterface $response): void
    {
        if ($this->canLogRequests()) {
            try {
                $responseBody = $response->getBody()->getContents();
            } catch (RuntimeException $e) {
                $responseBody = null;
            }

            $this->requestLogger->onResponseReceived($responseBody, $response->getStatusCode());
        }
    }

    protected function request(string $method, string $url, ?array $data = null): ResponseInterface
    {
        $usingHeaders = ['Accept' => 'application/json',];
        $usingHeaders = array_merge($usingHeaders, $data ? ['Content-Type' => 'application/x-www-form-urlencoded'] : []);
        $usingHeaders = array_merge($usingHeaders, $this->token ? ['Authorization' => "Bearer {$this->token}"] : []);

        $this->shouldLogRequest($method, $url, $data, $usingHeaders);

        try {
            $response = $this->httpClient->request($method, $url, [
                'form_params' => $data,
                'headers' => $usingHeaders,
            ]);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        $this->shouldLogResponse($response);
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
