<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Risk;

class ChannelId implements \Stringable
{
    private string $organizationId;
    private string $subclientId;

    public function __construct(string $channelId)
    {
        $this->guardAgainsInvalidChannelId($channelId);
        $this->organizationId = substr($channelId, 0, 6);
        $this->subclientId = substr($channelId, -6);
    }

    public static function fromString(string $channelid): self
    {
        return new self($channelid);
    }

    public function __toString(): string
    {
        return $this->organizationId . $this->subclientId;
    }

    private function guardAgainsInvalidChannelId(string $channelId): void
    {
        if (!preg_match('/^[0-9]{12}$/', $channelId)) {
            throw new \DomainException(sprintf('%s Channelid is not valid.', $channelId));
        }
    }
}
