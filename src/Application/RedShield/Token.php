<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Application\RedShield;

class Token implements \Stringable
{
    private string $token;

    public function __construct(string $token)
    {
        $token = trim($token);
        $this->guardAgainstInvalidToken($token);
        $this->token = $token;
    }

    public static function fromString(string $token): self
    {
        return new self($token);
    }

    public function __toString(): string
    {
        return $this->token;
    }

    private function guardAgainstInvalidToken(string $token): void
    {
        $decrypted = base64_decode($token, true);
        if (!$decrypted) {
            throw new \UnexpectedValueException(sprintf(
                '%s is not a valid token [1]',
                $token
            ));
        }

        list($userLogin, $userPassword) = explode('|', $decrypted . '|');
        if (empty($userLogin) || empty($userPassword)) {
            throw new \UnexpectedValueException(sprintf(
                '%s is not a valid token [2]',
                $token
            ));
        }
    }
}
