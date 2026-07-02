<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;
use Namecom\Core\Types\ArrayType;

class ZoneCheckRequest extends JsonSerializableType
{
    /**
     * Array of domain names to check. Each entry is normalized and validated before zone check runs. Entries that are not valid domain strings,  that use unsupported TLDs for this service, or that fail other pre-validation rules are omitted from the check; the response `removed` field  reports how many were omitted (not which values).
     *
     * **Valid domain string (after normalization)** — for reliable results and to avoid errors once all entries are removed:
     *
     * - **Allowed characters:** ASCII letters (`a`–`z`), digits (`0`–`9`), and hyphens (`-`).
     *
     * - **Hyphen rules:** A domain (the part between dots) must not start or end with a hyphen (for example, `-test.com` and `test-.com` are invalid).
     *
     * - **Domain length:** Each domain must be between 1 and 63 characters.
     *
     * - **Internationalized domains (IDNs):** Non-ASCII characters (for example `ö` or `ñ`) should be submitted as Punycode (`xn--...`) for  consistent registry resolution.
     *
     * @var array<string> $domainNames
     */
    #[JsonProperty('domainNames'), ArrayType(['string'])]
    public array $domainNames;

    /**
     * @param array{
     *   domainNames: array<string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->domainNames = $values['domainNames'];
    }
}
