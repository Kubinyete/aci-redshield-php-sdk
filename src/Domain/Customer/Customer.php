<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain\Customer;

use Jhernandes\Person\Domain\Date;
use Jhernandes\Person\Domain\Name;
use Jhernandes\Contacts\Domain\Email;
use Jhernandes\Contacts\Domain\Phone;
use Jhernandes\AciRedShield\Domain\Customer\Ip;
use Jhernandes\AciRedShield\Domain\Customer\Status;
use Jhernandes\AciRedShield\Domain\Customer\CustomerId;
use Jhernandes\AciRedShield\Domain\Customer\IdentificationDocId;

class Customer implements \JsonSerializable
{
    private CustomerId $merchantCustomerId;
    private Name $name;
    private ?IdentificationDocId $identificationDocId;
    private Status $status;

    private ?Date $birthDate;
    private ?Phone $phone;
    private ?Phone $mobile;
    private ?Email $email;
    private ?Ip $ip;
    private ?Fingerprint $browserFingerprint;

    public function __construct(string $merchantCustomerId, string $name, ?string $identificationDocId, ?string $identificationDocType = IdentificationDocId::TAXSTATEMENT)
    {
        $this->merchantCustomerId = CustomerId::fromString($merchantCustomerId);
        $this->name = Name::fromString($name);
        $this->identificationDocId = !$identificationDocType || !$identificationDocId ? null : IdentificationDocId::fromString($identificationDocId, $identificationDocType);
        $this->status = Status::fromString('NEW');

        $this->birthDate = null;
        $this->phone = null;
        $this->mobile = null;
        $this->email = null;
        $this->ip = null;
        $this->browserFingerprint = null;
    }

    public static function fromValues(string $merchantCustomerId, string $name, ?string $identificationDocId, ?string $identificationDocType = IdentificationDocId::TAXSTATEMENT): self
    {
        return new self($merchantCustomerId, $name, $identificationDocId, $identificationDocType);
    }

    public function setEmail(string $email): void
    {
        $this->email = Email::fromString($email);
    }

    public function setBirthdate(string $birthdate): void
    {
        $this->birthDate = Date::fromString($birthdate);
    }

    public function setPhone(string $phone): void
    {
        $this->phone = Phone::fromString($phone);
    }

    public function setMobile(string $mobile): void
    {
        $this->mobile  = Phone::fromString($mobile);
    }

    public function setIp(string $ip): void
    {
        $this->ip = Ip::fromString($ip);
    }

    public function setStatus(string $status): void
    {
        $this->status = Status::fromString($status);
    }

    public function setFingerprint(string $fingerprint): void
    {
        $this->browserFingerprint = Fingerprint::fromString($fingerprint);
    }

    public function jsonSerialize(): array
    {
        $customer = [
            'merchantCustomerId' => (string) $this->merchantCustomerId,
            'givenName' => $this->name->firstname(),
            'middleName' => '',
            'surname' => $this->name->lastname(),
            'birthDate' => (string) $this->birthDate ?? null,
            'phone' => (string) $this->phone ?? null,
            'mobile' => (string) $this->mobile ?? null,
            'email' => (string) $this->email ?? null,
            'ip' => (string) $this->ip ?? null,
            'identificationDocType' => $this->identificationDocId?->docType(),
            'identificationDocId' => $this->identificationDocId?->docId(),
            'status' => (string) $this->status,
        ];

        if (isset($this->browserFingerprint)) {
            $customer['browserFingerprint']['value'] = (string) $this->browserFingerprint;
        }

        return $customer;
    }
}
