<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Exception;

class ContactVerificationStatusChangeVerification extends JsonSerializableType
{
    /**
     * @var (
     *    'verified'
     *   |'unverified'
     *   |'_unknown'
     * ) $status
     */
    public readonly string $status;

    /**
     * @var (
     *    ContactVerificationStatusChangeVerificationVerified
     *   |ContactVerificationStatusChangeVerificationUnverified
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   status: (
     *    'verified'
     *   |'unverified'
     *   |'_unknown'
     * ),
     *   value: (
     *    ContactVerificationStatusChangeVerificationVerified
     *   |ContactVerificationStatusChangeVerificationUnverified
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->status = $values['status'];
        $this->value = $values['value'];
    }

    /**
     * @param ContactVerificationStatusChangeVerificationVerified $verified
     * @return ContactVerificationStatusChangeVerification
     */
    public static function verified(ContactVerificationStatusChangeVerificationVerified $verified): ContactVerificationStatusChangeVerification
    {
        return new ContactVerificationStatusChangeVerification([
            'status' => 'verified',
            'value' => $verified,
        ]);
    }

    /**
     * @param ContactVerificationStatusChangeVerificationUnverified $unverified
     * @return ContactVerificationStatusChangeVerification
     */
    public static function unverified(ContactVerificationStatusChangeVerificationUnverified $unverified): ContactVerificationStatusChangeVerification
    {
        return new ContactVerificationStatusChangeVerification([
            'status' => 'unverified',
            'value' => $unverified,
        ]);
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->value instanceof ContactVerificationStatusChangeVerificationVerified && $this->status === 'verified';
    }

    /**
     * @return ContactVerificationStatusChangeVerificationVerified
     */
    public function asVerified(): ContactVerificationStatusChangeVerificationVerified
    {
        if (!($this->value instanceof ContactVerificationStatusChangeVerificationVerified && $this->status === 'verified')) {
            throw new Exception(
                "Expected verified; got " . $this->status . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isUnverified(): bool
    {
        return $this->value instanceof ContactVerificationStatusChangeVerificationUnverified && $this->status === 'unverified';
    }

    /**
     * @return ContactVerificationStatusChangeVerificationUnverified
     */
    public function asUnverified(): ContactVerificationStatusChangeVerificationUnverified
    {
        if (!($this->value instanceof ContactVerificationStatusChangeVerificationUnverified && $this->status === 'unverified')) {
            throw new Exception(
                "Expected unverified; got " . $this->status . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        $result = [];
        $result['status'] = $this->status;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->status) {
            case 'verified':
                $value = $this->asVerified()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'unverified':
                $value = $this->asUnverified()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case '_unknown':
            default:
                if (is_null($this->value)) {
                    break;
                }
                if ($this->value instanceof JsonSerializableType) {
                    $value = $this->value->jsonSerialize();
                    $result = array_merge($value, $result);
                } elseif (is_array($this->value)) {
                    $result = array_merge($this->value, $result);
                }
        }

        return $result;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function jsonDeserialize(array $data): static
    {
        $args = [];
        if (!array_key_exists('status', $data)) {
            throw new Exception(
                "JSON data is missing property 'status'",
            );
        }
        $status = $data['status'];
        if (!(is_string($status))) {
            throw new Exception(
                "Expected property 'status' in JSON data to be string, instead received " . get_debug_type($data['status']),
            );
        }

        $args['status'] = $status;
        switch ($status) {
            case 'verified':
                $args['value'] = ContactVerificationStatusChangeVerificationVerified::jsonDeserialize($data);
                break;
            case 'unverified':
                $args['value'] = ContactVerificationStatusChangeVerificationUnverified::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['status'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
