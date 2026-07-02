<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Contact contains all relevant contact data for a domain registrant. This schema is used for API responses and may contain null values for legacy data. For creating or updating contacts, use ContactRequest which enforces all validation requirements.
 */
class Contact extends JsonSerializableType
{
    /**
     * @var ?string $firstName First name of the contact.
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * @var ?string $lastName Last name of the contact.
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * @var ?string $companyName Company name of the contact. Leave blank if the contact is an individual, as some registries may assume it is a corporate entity otherwise.
     */
    #[JsonProperty('companyName')]
    public ?string $companyName;

    /**
     * @var ?string $address1 The first line of the contact's address.
     */
    #[JsonProperty('address1')]
    public ?string $address1;

    /**
     * @var ?string $address2 The second line of the contact's address (optional).
     */
    #[JsonProperty('address2')]
    public ?string $address2;

    /**
     * @var ?string $city City of the contact's address.
     */
    #[JsonProperty('city')]
    public ?string $city;

    /**
     * @var ?string $state State or Province of the contact's address.
     */
    #[JsonProperty('state')]
    public ?string $state;

    /**
     * @var ?string $zip ZIP or Postal Code of the contact's address.
     */
    #[JsonProperty('zip')]
    public ?string $zip;

    /**
     * @var ?string $country Country code for the contact's address. Must be an ISO 3166-1 alpha-2 country code.
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @var ?string $email Email address of the contact. Must be a valid email format. The validation is performed against the `addr-spec` syntax in [RFC 822](https://datatracker.ietf.org/doc/html/rfc822)
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * @var ?string $phone Phone number of the contact. Should follow the E.164 international format: "+[country code][number]".
     */
    #[JsonProperty('phone')]
    public ?string $phone;

    /**
     * @var ?string $fax Fax number of the contact. Should follow the E.164 international format: "+[country code][number]".
     */
    #[JsonProperty('fax')]
    public ?string $fax;

    /**
     * @var ?bool $isVerified Indicates if the contact has been verified as per ICANN requirements. If the value is `false` it indicates that the contact has not completed the required verification process. This property is read-only and will be included in responses but should not be included in requests.
     */
    #[JsonProperty('isVerified')]
    public ?bool $isVerified;

    /**
     * @var ?int $verificationId When the contact is unverified, this is the ID of the pending verification record. Use this ID with the resend verification email and verify contact endpoints. Omitted or null when the contact is verified.
     */
    #[JsonProperty('verificationId')]
    public ?int $verificationId;

    /**
     * @param array{
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   companyName?: ?string,
     *   address1?: ?string,
     *   address2?: ?string,
     *   city?: ?string,
     *   state?: ?string,
     *   zip?: ?string,
     *   country?: ?string,
     *   email?: ?string,
     *   phone?: ?string,
     *   fax?: ?string,
     *   isVerified?: ?bool,
     *   verificationId?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->companyName = $values['companyName'] ?? null;
        $this->address1 = $values['address1'] ?? null;
        $this->address2 = $values['address2'] ?? null;
        $this->city = $values['city'] ?? null;
        $this->state = $values['state'] ?? null;
        $this->zip = $values['zip'] ?? null;
        $this->country = $values['country'] ?? null;
        $this->email = $values['email'] ?? null;
        $this->phone = $values['phone'] ?? null;
        $this->fax = $values['fax'] ?? null;
        $this->isVerified = $values['isVerified'] ?? null;
        $this->verificationId = $values['verificationId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
