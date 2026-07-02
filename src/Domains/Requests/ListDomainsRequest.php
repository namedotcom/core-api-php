<?php

namespace Namecom\Domains\Requests;

use Namecom\Core\Json\JsonSerializableType;

class ListDomainsRequest extends JsonSerializableType
{
    /**
     * @var ?int $perPage Per Page is the number of records to return per request. Per Page defaults to 250.
     */
    public ?int $perPage;

    /**
     * @var ?int $page Page is which page to return.
     */
    public ?int $page;

    /**
     * @var ?string $sort Sort specifies which domain property to order by.
     */
    public ?string $sort;

    /**
     * @var ?string $dir Dir indicates direction of sort. Possible values are 'asc' (default) or 'desc'.
     */
    public ?string $dir;

    /**
     * @var ?string $domainName DomainName filters domains by exact domain name or wildcard (starts with '*').
     */
    public ?string $domainName;

    /**
     * @var ?string $tld Tld filters on specific tld.
     */
    public ?string $tld;

    /**
     * @var ?bool $locked Locked filters on locked domains.
     */
    public ?bool $locked;

    /**
     * @var ?string $createDate CreateDate filters domains created on this date.
     */
    public ?string $createDate;

    /**
     * @var ?string $createDateStart CreateDateStart filters domains created on or after this date.
     */
    public ?string $createDateStart;

    /**
     * @var ?string $createDateEnd CreateDateEnd filters domains created on or before this date.
     */
    public ?string $createDateEnd;

    /**
     * @var ?string $expireDate ExpireDate filters domains expiring on this date.
     */
    public ?string $expireDate;

    /**
     * @var ?string $expireDateStart ExpireDateStart filters domains with expire date on or after this date.
     */
    public ?string $expireDateStart;

    /**
     * @var ?string $expireDateEnd ExpireDateEnd filters domains with expire date on or before this date.
     */
    public ?string $expireDateEnd;

    /**
     * @var ?bool $privacyEnabled PrivacyEnabled indicates whether there is a privacy product associated with the domain.
     */
    public ?bool $privacyEnabled;

    /**
     * @var ?bool $isPremium IsPremium indicates whether the domain is a premium domain.
     */
    public ?bool $isPremium;

    /**
     * @var ?bool $autorenewEnabled AutorenewEnabled indicates if the domain will attempt to renew automatically before expiration.
     */
    public ?bool $autorenewEnabled;

    /**
     * @var ?int $orderId OrderId specifies the order number of a domain purchase.
     */
    public ?int $orderId;

    /**
     * @var ?bool $includeRenewalPrice IncludeRenewalPrice indicates whether to include renewal pricing information in the response.
     */
    public ?bool $includeRenewalPrice;

    /**
     * @param array{
     *   perPage?: ?int,
     *   page?: ?int,
     *   sort?: ?string,
     *   dir?: ?string,
     *   domainName?: ?string,
     *   tld?: ?string,
     *   locked?: ?bool,
     *   createDate?: ?string,
     *   createDateStart?: ?string,
     *   createDateEnd?: ?string,
     *   expireDate?: ?string,
     *   expireDateStart?: ?string,
     *   expireDateEnd?: ?string,
     *   privacyEnabled?: ?bool,
     *   isPremium?: ?bool,
     *   autorenewEnabled?: ?bool,
     *   orderId?: ?int,
     *   includeRenewalPrice?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->perPage = $values['perPage'] ?? null;
        $this->page = $values['page'] ?? null;
        $this->sort = $values['sort'] ?? null;
        $this->dir = $values['dir'] ?? null;
        $this->domainName = $values['domainName'] ?? null;
        $this->tld = $values['tld'] ?? null;
        $this->locked = $values['locked'] ?? null;
        $this->createDate = $values['createDate'] ?? null;
        $this->createDateStart = $values['createDateStart'] ?? null;
        $this->createDateEnd = $values['createDateEnd'] ?? null;
        $this->expireDate = $values['expireDate'] ?? null;
        $this->expireDateStart = $values['expireDateStart'] ?? null;
        $this->expireDateEnd = $values['expireDateEnd'] ?? null;
        $this->privacyEnabled = $values['privacyEnabled'] ?? null;
        $this->isPremium = $values['isPremium'] ?? null;
        $this->autorenewEnabled = $values['autorenewEnabled'] ?? null;
        $this->orderId = $values['orderId'] ?? null;
        $this->includeRenewalPrice = $values['includeRenewalPrice'] ?? null;
    }
}
