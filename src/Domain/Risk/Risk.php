<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Risk;

use Jhernandes\AciRedShield\Domain\Risk\Parameters;

class Risk implements \JsonSerializable
{
    private Parameters $parameters;
    private ChannelId $channelId;
    private ServiceId $serviceId;

    public function __construct(string $channelId, string $serviceId, array $userDataList = [])
    {
        $this->channelId = ChannelId::fromString($channelId);
        $this->serviceId = ServiceId::fromString($serviceId);
        $this->parameters = Parameters::fromList($userDataList);
    }

    public static function fromValues(string $channelId, string $serviceId, array $userDataList = []): self
    {
        return new self($channelId, $serviceId, $userDataList);
    }

    public function addUserData(string $value): void
    {
        $this->parameters->addUserData(substr($value, 0, 255));
    }

    public function addTimeOnFile(int $timeOnFile): void
    {
        $this->parameters->addTimeOnFile($timeOnFile);
    }

    public function jsonSerialize(): array
    {
        return array_merge([
            'channelId' => (string) $this->channelId,
            'serviceId' => (string) $this->serviceId,
        ], $this->parameters->jsonSerialize());
    }
}
