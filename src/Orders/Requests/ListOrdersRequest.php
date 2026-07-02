<?php

namespace Namecom\Orders\Requests;

use Namecom\Core\Json\JsonSerializableType;
use Namecom\Orders\Types\ListOrdersRequestOrderStatus;

class ListOrdersRequest extends JsonSerializableType
{
    /**
     * @var ?int $perPage Per Page is the number of records to return per request. Per Page defaults to 500.
     */
    public ?int $perPage;

    /**
     * @var ?int $page Page is which page to return.
     */
    public ?int $page;

    /**
     * @var ?string $dir Dir indicates direction of list order. Possible values are 'asc' (default) or 'desc'.
     */
    public ?string $dir;

    /**
     * @var ?string $domainName DomainName filters orders by domain name. Supports exact match or wildcard (starts with '*').
     */
    public ?string $domainName;

    /**
     * @var ?string $tld Tld filters orders by tld.
     */
    public ?string $tld;

    /**
     * @var ?string $createDateStart CreateDateStart filters orders created on or after this date.
     */
    public ?string $createDateStart;

    /**
     * @var ?string $createDateEnd CreateDateEnd filters orders created on or before this date.
     */
    public ?string $createDateEnd;

    /**
     * @var ?string $type Type filters orders by order item type (e.g., 'registration', 'renewal', 'transfer', 'whois_privacy').
     */
    public ?string $type;

    /**
     * @var ?value-of<ListOrdersRequestOrderStatus> $orderStatus OrderStatus filters orders by status.
     */
    public ?string $orderStatus;

    /**
     * @param array{
     *   perPage?: ?int,
     *   page?: ?int,
     *   dir?: ?string,
     *   domainName?: ?string,
     *   tld?: ?string,
     *   createDateStart?: ?string,
     *   createDateEnd?: ?string,
     *   type?: ?string,
     *   orderStatus?: ?value-of<ListOrdersRequestOrderStatus>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->perPage = $values['perPage'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->dir = $values['dir'] ?? null;
        $this->domainName = $values['domainName'] ?? null;
        $this->tld = $values['tld'] ?? null;
        $this->createDateStart = $values['createDateStart'] ?? null;
        $this->createDateEnd = $values['createDateEnd'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->orderStatus = $values['orderStatus'] ?? null;
    }
}
