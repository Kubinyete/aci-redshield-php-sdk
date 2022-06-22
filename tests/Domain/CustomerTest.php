<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield;

use PHPUnit\Framework\TestCase;
use Jhernandes\AciRedShield\Domain\Customer;

class CustomerTest extends TestCase
{
    public function testCanCreateFromMinimumValidValues(): void
    {
        $this->assertInstanceOf(
            Customer::class,
            Customer::fromValues('20000', 'Jose do Egito', '79999338801')
        );
    }

    public function testCanCreateAndSetExtraFields(): void
    {
        $customer = Customer::fromValues('20000', 'Jose do Egito', '79999338801');
        $customer->setEmail('jose@egito.com.br');
        $customer->setPhone('11 90000-1234');
        $customer->setMobile('11 90901-1010');
        $customer->setBirthdate('1978-10-03');
        $customer->setIp('127.0.0.1');
        $customer->setStatus('EXISTING');

        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testCanBeRepresentedAsArray(): void
    {
        $customer = Customer::fromValues('20000', 'Jose do Egito', '79999338801');
        $customer->setEmail('jose@egito.com.br');
        $customer->setPhone('11 90000-1234');
        $customer->setMobile('11 90901-1010');
        $customer->setBirthdate('1978-10-03');
        $customer->setIp('127.0.0.1');
        $customer->setStatus('EXISTING');

        $this->assertSame([
            'merchantCustomerId' => '20000',
            'givenName' => 'Jose',
            'middleName' => '',
            'surname' => 'do Egito',
            'birthDate' => '1978-10-03',
            'phone' => '(11) 90000-1234',
            'mobile' => '(11) 90901-1010',
            'email' => 'jose@egito.com.br',
            'ip' => '127.0.0.1',
            'identificationDocType' => 'TAXSTATEMENT',
            'identificationDocId' => '79999338801',
            'status' => 'EXISTING',
        ], $customer->jsonSerialize());
    }
}
