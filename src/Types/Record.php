<?php

namespace Namecom\Types;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Core\Json\JsonProperty;

/**
 * Record is an individual DNS resource record.
 */
class Record extends JsonSerializableType
{
    /**
     * Answer is either the IP address for A or AAAA records; the target for ANAME, CNAME, MX, or NS records; the text for TXT records.
     * For SRV records, answer has the following format: "{weight} {port} {target}" e.g. "1 5061 sip.example.org".
     *
     * @var ?string $answer
     */
    #[JsonProperty('answer')]
    public ?string $answer;

    /**
     * @var ?string $domainName DomainName is the zone that the record belongs to.
     */
    #[JsonProperty('domainName')]
    public ?string $domainName;

    /**
     * @var ?string $fqdn FQDN is the Fully Qualified Domain Name. It is the combination of the host and the domain name. It always ends in a ".". FQDN is ignored in CreateRecord, specify via the Host field instead.
     */
    #[JsonProperty('fqdn')]
    public ?string $fqdn;

    /**
     * Host is the hostname relative to the zone: e.g. for a record for blog.example.org, domain would be "example.org" and host would be "blog".
     * An apex record would be specified by either an empty host "" or "@".
     * A SRV record would be specified by "_{service}._{protocol}.{host}": e.g. "_sip._tcp.phone" for _sip._tcp.phone.example.org.
     *
     * @var ?string $host
     */
    #[JsonProperty('host')]
    public ?string $host;

    /**
     * @var ?int $id Unique record id. Value is ignored on Create, and must match the URI on Update.
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?int $priority Priority is only required for MX and SRV records, it is ignored for all others.
     */
    #[JsonProperty('priority')]
    public ?int $priority;

    /**
     * @var int $ttl TTL is the time this record can be cached for in seconds. name.com allows a minimum TTL of 300, or 5 minutes.
     */
    #[JsonProperty('ttl')]
    public int $ttl;

    /**
     * @var ?string $type Type is one of the following: A, AAAA, ANAME, CNAME, MX, NS, SRV, or TXT.
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @param array{
     *   ttl: int,
     *   answer?: ?string,
     *   domainName?: ?string,
     *   fqdn?: ?string,
     *   host?: ?string,
     *   id?: ?int,
     *   priority?: ?int,
     *   type?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->answer = $values['answer'] ?? null;
        $this->domainName = $values['domainName'] ?? null;
        $this->fqdn = $values['fqdn'] ?? null;
        $this->host = $values['host'] ?? null;
        $this->id = $values['id'] ?? null;
        $this->priority = $values['priority'] ?? null;
        $this->ttl = $values['ttl'];
        $this->type = $values['type'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
