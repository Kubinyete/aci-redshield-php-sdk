<?php

declare(strict_types=1);

namespace Jhernandes\AciRedShield\Domain;

use Jhernandes\AciRedShield\Domain\Shared\Text;
use Jhernandes\AciRedShield\Domain\Shared\Country;
use Jhernandes\AciRedShield\Domain\Shared\Postcode;
use Jhernandes\AciRedShield\Domain\Customer\Customer;

class Shipping implements \JsonSerializable
{
    private const HOUSENUMBER_MAXLENGHT = 30;
    private const STREET_MAXLENGHT = 30;
    private const CITY_MAXLENGHT = 30;

    /** @var string $postcode maxLength=10 */
    private Postcode $postcode;

    /** @var string $houseNumber1 (complemento) maxLength=30 */
    private Text $houseNumber1;

    /** @var string $street1 (street, number) maxLength=30 */
    private Text $street1;

    /** @var string $street2 (bairro) maxLength=30 */
    private Text $street2;

    /** @var string $city maxLength=20 */
    private Text $city;

    /** @var string $city maxLength=2 */
    private Text $state;

    /** @var string $country maxLength=2 */
    private Country $country;

    private Customer $customer;

    public function __construct(
        string $postcode,
        string $street1,
        string $street2,
        string $houseNumber1,
        string $city,
        string $state,
        string $country
    ) {
        $this->postcode = Postcode::fromString($postcode);
        $this->street1 = Text::fromString($street1, self::STREET_MAXLENGHT, true);
        $this->street2 = Text::fromString($street2, self::STREET_MAXLENGHT, true);
        $this->houseNumber1 = Text::fromString($houseNumber1, self::HOUSENUMBER_MAXLENGHT, true);
        $this->city = Text::fromString($city, self::CITY_MAXLENGHT, true);
        $this->state = Text::fromString($state, 2, true);
        $this->country = Country::fromAlpha2($country);
    }

    public static function fromValues(
        string $postcode,
        string $street1,
        string $street2,
        string $houseNumber1,
        string $city,
        string $state,
        string $country = 'BR'
    ): self {
        return new self(
            $postcode,
            $street1,
            $street2,
            $houseNumber1,
            $city,
            $state,
            $country
        );
    }

    public function addCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function jsonSerialize(): array
    {
        $shipping = [
            'houseNumber1' => (string) $this->houseNumber1,
            'street1' => (string) $this->street1,
            'street2' => (string) $this->street2,
            'city' => (string) $this->city,
            'state' => (string) $this->state,
            'country' => (string) $this->country,
            'postcode' => (string) $this->postcode,
        ];

        if (isset($this->customer)) {
            $shipping['customer'] = array_filter(
                $this->customer->jsonSerialize(),
                fn ($key) => in_array($key, [
                    'email',
                    'phone',
                    'givenName',
                    'middleName',
                    'surname',
                ]),
                ARRAY_FILTER_USE_KEY
            );
        }
        return $shipping;
    }
}
