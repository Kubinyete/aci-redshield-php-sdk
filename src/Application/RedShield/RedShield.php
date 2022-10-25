<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Application\RedShield;

use Jhernandes\AciRedShield\Domain\Order;
use Jhernandes\AciRedShield\Application\Http\Request;
use Jhernandes\AciRedShield\Application\Helpers\ArrayHelper;
use Jhernandes\AciRedShield\Application\RedShield\RedShieldResponse;
use Throwable;

class RedShield
{
    private Request $request;
    private Environment $environment;

    public function __construct(string $environment, string $token)
    {
        $this->request = new Request();
        $this->request->setBearerToken($token);
        $this->environment = Environment::fromString($environment);
    }

    public function register(Order $order): RedShieldResponse
    {
        try {
            $formData = ArrayHelper::toFormData($order->jsonSerialize());

            if (!$this->environment->isProduction()) {
                $formData['testMode'] = 'EXTERNAL';
            }

            $response = $this->request->post($this->environment->url(), $formData);
            return RedShieldResponse::fromResponse($response);
        } catch (Throwable $e) {
            throw new \RuntimeException('There was a problem to register the order.');
        }
    }
}
