<?php

namespace Namecom\Domains;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Domains\Requests\ListDomainsRequest;
use Namecom\Types\ListDomainsResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\Domains\Requests\CreateDomainRequest;
use Namecom\Types\CreateDomainResponse;
use Namecom\Types\DomainResponsePayload;
use Namecom\Domains\Requests\UpdateDomainRequest;
use Namecom\Domains\Requests\DisableAutorenewRequest;
use Namecom\Types\Domain;
use Namecom\Domains\Requests\DisableWhoisPrivacyRequest;
use Namecom\Domains\Requests\EnableAutorenewRequest;
use Namecom\Domains\Requests\EnableWhoisPrivacyRequest;
use Namecom\Types\AuthCodeResponse;
use Namecom\Domains\Requests\GetPricingForDomainRequest;
use Namecom\Types\PricingResponse;
use Namecom\Domains\Requests\LockDomainRequest;
use Namecom\Domains\Requests\DomainsPurchasePrivacyBody;
use Namecom\Types\PrivacyResponse;
use Namecom\Domains\Requests\DomainsRenewDomainBody;
use Namecom\Types\RenewDomainResponse;
use Namecom\Domains\Requests\DomainsSetContactsBody;
use Namecom\Domains\Requests\DomainsSetNameserversBody;
use Namecom\Domains\Requests\UnlockDomainRequest;
use Namecom\Domains\Requests\AvailabilityRequest;
use Namecom\Types\SearchResponse;
use Namecom\Domains\Requests\SearchRequest;
use Namecom\Domains\Requests\ZoneCheckRequest;
use Namecom\Types\ZoneCheckResponse;

class DomainsClient
{
    /**
     * @var array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options @phpstan-ignore-next-line Property is used in endpoint methods via HttpEndpointGenerator
     */
    private array $options;

    /**
     * @var RawClient $client
     */
    private RawClient $client;

    /**
     * @param RawClient $client
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        RawClient $client,
        ?array $options = null,
    ) {
        $this->client = $client;
        $this->options = $options ?? [];
    }

    /**
     * Lists all domains in your account (basic details for each domain).
     *
     * Example:
     * ```php
     * $client->domains->listDomains(
     *     new ListDomainsRequest([]),
     * );
     * ```
     *
     * @param ListDomainsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListDomainsResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listDomains(ListDomainsRequest $request = new ListDomainsRequest(), ?array $options = null): ?ListDomainsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->perPage != null) {
            $query['perPage'] = $request->perPage;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->sort != null) {
            $query['sort'] = $request->sort;
        }
        if ($request->dir != null) {
            $query['dir'] = $request->dir;
        }
        if ($request->domainName != null) {
            $query['domainName'] = $request->domainName;
        }
        if ($request->tld != null) {
            $query['tld'] = $request->tld;
        }
        if ($request->locked != null) {
            $query['locked'] = $request->locked;
        }
        if ($request->createDate != null) {
            $query['createDate'] = $request->createDate;
        }
        if ($request->createDateStart != null) {
            $query['createDateStart'] = $request->createDateStart;
        }
        if ($request->createDateEnd != null) {
            $query['createDateEnd'] = $request->createDateEnd;
        }
        if ($request->expireDate != null) {
            $query['expireDate'] = $request->expireDate;
        }
        if ($request->expireDateStart != null) {
            $query['expireDateStart'] = $request->expireDateStart;
        }
        if ($request->expireDateEnd != null) {
            $query['expireDateEnd'] = $request->expireDateEnd;
        }
        if ($request->privacyEnabled != null) {
            $query['privacyEnabled'] = $request->privacyEnabled;
        }
        if ($request->isPremium != null) {
            $query['isPremium'] = $request->isPremium;
        }
        if ($request->autorenewEnabled != null) {
            $query['autorenewEnabled'] = $request->autorenewEnabled;
        }
        if ($request->orderId != null) {
            $query['orderId'] = $request->orderId;
        }
        if ($request->includeRenewalPrice != null) {
            $query['includeRenewalPrice'] = $request->includeRenewalPrice;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return ListDomainsResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Registers a new domain under your account. You must provide `domain.domainName` at minimum.
     * This endpoint is commonly used to programmatically onboard new domains through user signup flows or checkout experiences.
     *
     * If no contacts are passed in this request, the default contacts for your name.com account will be used.
     *
     * ### Create Domain pricing
     *
     * See the [Domain purchase pricing guide](/guides/domain-pricing) for the full reference.
     * **Recommendation:** For most integrations, scope discovery to `purchaseType: registration`. Other purchase types are supported but add complexity — details in the guide above.
     *
     * **Discovery (required before create):** Call [Search](/api/v1/reference/domains/search) or [Check Availability](/api/v1/reference/domains/check-availability), not Get Pricing alone. Both return the same `SearchResult` fields (`purchaseType`, `purchasePrice`, `premium`, `purchasable`). [Zone Check](/api/v1/reference/domains/zone-check) is designed for rapid availability checks only; it is not sufficient to complete a purchase.
     *
     * ### Getting the price for Create Domain
     *
     * 1. **Search or Check Availability** → copy `purchaseType`, `premium`, note `purchasePrice`.
     *
     * 2. Branch on `purchaseType`:
     *    - **`registration` + `premium: false`** — omit `purchasePrice` on create, set `years`. Optional: Get Pricing with same `years` to preview the total.
     *    - **`registration` + `premium: true`** — Get Pricing with same `years` → pass `purchasePrice` exactly.
     *    - **aftermarket / expiring / backorder** — use discovery `purchasePrice` (flat fee). Re-check discovery before create. Do not use Get Pricing for create price. `years` does not multiply price or guarantee registration length.
     *
     * 3. If `purchasePrice` is sent, it must match exactly or the request fails with `400` and `"Purchase price does not match"`.
     *
     * **Years on acquisition types:** For `aftermarket_s`, `aftermarket_b`, `aftermarket_i`, `expiring`, and `backorder`: omit `years` or pass the TLD default. Check `domain.expireDate` in the response; [Renew](/api/v1/reference/domains/renew-domain) to extend registration.
     *
     * ### Best Practices For Domain Creates
     *
     * In general, you should check that a domain is available prior to attempting to purchase a domain.
     * You can use either the [checkAvailability](/api/v1/reference/domains/check-availability) endpoint, or the [Search](/api/v1/reference/domains/search) endpoint
     * to confirm that a domain is purchasable.
     *
     * #### Important Note on Dropcatching and Abuse Prevention
     *
     * _The createDomain endpoint is designed for standard domain registrations and is not intended for automated dropcatching (i.e., mass or high-frequency attempts to register domains the moment they become available after expiration). The use of drop-catching tools or services to acquire expired domains is strictly prohibited. All domain acquisitions must go through approved channels to ensure fair and transparent access._
     *
     * #### Contact Verification
     * When a new domain registration is created and a contact is submitted, name.com may need to validate the contact's email address in accordance with ICANN policy. This validation involves sending an email to the provided address, prompting the recipient to click a link to verify their email address.
     *
     * Example:
     * ```php
     * $client->domains->createDomain(
     *     new CreateDomainRequest([
     *         'domain' => new DomainCreatePayload([
     *             'domainName' => 'example.com',
     *         ]),
     *     ]),
     * );
     * ```
     *
     * @param CreateDomainRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?CreateDomainResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createDomain(CreateDomainRequest $request, ?array $options = null): ?CreateDomainResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return CreateDomainResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Retrieves detailed information for a specific domain in your account.
     *
     * Example:
     * ```php
     * $client->domains->getDomain(
     *     'example.com',
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to retrieve.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?DomainResponsePayload
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getDomain(string $domainName, ?array $options = null): ?DomainResponsePayload
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return DomainResponsePayload::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Allows updating of the autorenew, WhoIs Privacy and lock status of the specified domain. The request requires one, or any combination of the parameters in order to pass validation. If any of the requested updates failed, the domain will be returned to it's original state.
     *
     * Example:
     * ```php
     * $client->domains->updateDomain(
     *     'domainName',
     *     new UpdateDomainRequest([
     *         'body' => new UpdateDomainRequestBodyAutorenewEnabled([
     *             'autorenewEnabled' => true,
     *         ]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to update.
     * @param UpdateDomainRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?DomainResponsePayload
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function updateDomain(string $domainName, UpdateDomainRequest $request, ?array $options = null): ?DomainResponsePayload
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}",
                    method: HttpMethod::PATCH,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return DomainResponsePayload::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Turns off automatic renewal for a domain. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
     *
     * Example:
     * ```php
     * $client->domains->disableAutorenew(
     *     'example.com',
     *     new DisableAutorenewRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to disable autorenew for.
     * @param DisableAutorenewRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Domain
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function disableAutorenew(string $domainName, DisableAutorenewRequest $request, ?array $options = null): ?Domain
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:disableAutorenew",
                    method: HttpMethod::POST,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Domain::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Disables WHOIS privacy protection on a domain. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
     *
     * Example:
     * ```php
     * $client->domains->disableWhoisPrivacy(
     *     'example.com',
     *     new DisableWhoisPrivacyRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to disable whoisprivacy for.
     * @param DisableWhoisPrivacyRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Domain
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function disableWhoisPrivacy(string $domainName, DisableWhoisPrivacyRequest $request, ?array $options = null): ?Domain
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:disableWhoisPrivacy",
                    method: HttpMethod::POST,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Domain::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Turns on automatic renewal for a domain. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
     *
     * Example:
     * ```php
     * $client->domains->enableAutorenew(
     *     'example.com',
     *     new EnableAutorenewRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to enable autorenew for.
     * @param EnableAutorenewRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Domain
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function enableAutorenew(string $domainName, EnableAutorenewRequest $request, ?array $options = null): ?Domain
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:enableAutorenew",
                    method: HttpMethod::POST,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Domain::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Enables WHOIS privacy protection on a domain. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
     *
     * Example:
     * ```php
     * $client->domains->enableWhoisPrivacy(
     *     'domainName',
     *     new EnableWhoisPrivacyRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to enable whoisprivacy for.
     * @param EnableWhoisPrivacyRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Domain
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function enableWhoisPrivacy(string $domainName, EnableWhoisPrivacyRequest $request, ?array $options = null): ?Domain
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:enableWhoisPrivacy",
                    method: HttpMethod::POST,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Domain::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Retrieves the transfer authorization code (EPP code) for a domain.
     *
     * Example:
     * ```php
     * $client->domains->getAuthCodeForDomain(
     *     'domainName',
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to retrieve the authorization code for.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?AuthCodeResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getAuthCodeForDomain(string $domainName, ?array $options = null): ?AuthCodeResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:getAuthCode",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return AuthCodeResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Returns registration, renewal, and transfer pricing for a domain and term.
     *
     * **Not a discovery endpoint:** Does not return `purchaseType`. Cannot determine whether a domain is acquired via registration vs aftermarket/expiring/backorder — call [Search](/api/v1/reference/domains/search) or [Check Availability](/api/v1/reference/domains/check-availability) first.
     *
     * **Scope:** `purchasePrice` and `premium` reflect **standard and registry-premium registration** only. They do **not** return aftermarket, expiring, or backorder acquisition prices. For those types, use `purchasePrice` from Search or Check Availability.
     *
     * **Registration create (`purchaseType: registration`):** When create requires `purchasePrice` (registry premium), call with the **same** `years` you will send on create. Pass `purchasePrice` directly — it is the **total** for that term, not a per-year component.
     *
     * **Renew:** Pass `renewalPrice` as `purchasePrice` on [Renew Domain](/api/v1/reference/domains/renew-domain) for premium renewals — not for computing Create Domain totals.
     *
     * **Transfer:** Pass `transferPrice` as `purchasePrice` on [Create Transfer](/api/v1/reference/transfers/create-transfer) for premium transfers. The `years` query parameter does not affect `transferPrice`.
     *
     * See the [Domain pricing guide](/guides/domain-pricing) for the full workflow.
     *
     * Example:
     * ```php
     * $client->domains->getPricingForDomain(
     *     'domainName',
     *     new GetPricingForDomainRequest([
     *         'years' => 2,
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to retrieve.
     * @param GetPricingForDomainRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?PricingResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getPricingForDomain(string $domainName, GetPricingForDomainRequest $request = new GetPricingForDomainRequest(), ?array $options = null): ?PricingResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->years != null) {
            $query['years'] = $request->years;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:getPricing",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return PricingResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Locks a domain to prevent it from being transferred. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
     *
     * Example:
     * ```php
     * $client->domains->lockDomain(
     *     'example.com',
     *     new LockDomainRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to lock.
     * @param LockDomainRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Domain
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function lockDomain(string $domainName, LockDomainRequest $request, ?array $options = null): ?Domain
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:lock",
                    method: HttpMethod::POST,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Domain::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Adds or renews WHOIS privacy protection for a domain. This is used to ensure personal contact details remain hidden from public WHOIS lookups.  If WHOIS privacy is already enabled, this will extend the protection. If it’s not yet active, this will enable the service.  WHOIS privacy is free for API users and does not add a fee.
     *
     * Example:
     * ```php
     * $client->domains->purchasePrivacy(
     *     'domainName',
     *     new DomainsPurchasePrivacyBody([]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to enable or extend Whois Privacy for.
     * @param DomainsPurchasePrivacyBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?PrivacyResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function purchasePrivacy(string $domainName, DomainsPurchasePrivacyBody $request = new DomainsPurchasePrivacyBody(), ?array $options = null): ?PrivacyResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:purchasePrivacy",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return PrivacyResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Renews an existing domain for an additional registration period. Include the domain name and renewal term. Omit `purchasePrice` for standard (non-premium) renewals. For premium renewals, pass `renewalPrice` from [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) with matching `years` as `purchasePrice`. Renewal pricing is separate from Create Domain registration/acquisition pricing. This is typically used to extend ownership before a domain’s expiration.
     *
     * Example:
     * ```php
     * $client->domains->renewDomain(
     *     'domainName',
     *     new DomainsRenewDomainBody([]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to renew.
     * @param DomainsRenewDomainBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?RenewDomainResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function renewDomain(string $domainName, DomainsRenewDomainBody $request = new DomainsRenewDomainBody(), ?array $options = null): ?RenewDomainResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:renew",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return RenewDomainResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Updates WHOIS contact information for a domain. This includes the registrant, administrative, technical, and billing contacts.  All contact objects must be complete — partial updates are not supported.  You should fetch the existing contact data first (e.g., via [GetDomain](/api/v1/reference/domains/get-domain) and modify only the values you wish to change.  This call replaces all four contact sets at once.
     * #### Contact Verification
     * When registrant contact information is updated, validation may be triggered if the new contact information has not been previously validated. This validation is required by ICANN for all TLDs except country-code TLDs (ccTLDs). This validation involves sending an email to the provided address, prompting the recipient to click a link to verify their email address.
     *
     * Example:
     * ```php
     * $client->domains->setContacts(
     *     'example.com',
     *     new DomainsSetContactsBody([]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to set the contacts for.
     * @param DomainsSetContactsBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?DomainResponsePayload
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function setContacts(string $domainName, DomainsSetContactsBody $request = new DomainsSetContactsBody(), ?array $options = null): ?DomainResponsePayload
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:setContacts",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return DomainResponsePayload::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * SetNameservers will set the nameservers for the Domain. This operation updates the DNS configuration by changing which nameservers are responsible for the domain's zone.
     *
     * Example:
     * ```php
     * $client->domains->setNameservers(
     *     'example.com',
     *     new DomainsSetNameserversBody([
     *         'nameservers' => [
     *             'ns1.name.com',
     *             'ns2.name.com',
     *         ],
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to set the nameservers for.
     * @param DomainsSetNameserversBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?DomainResponsePayload
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function setNameservers(string $domainName, DomainsSetNameserversBody $request, ?array $options = null): ?DomainResponsePayload
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:setNameservers",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return DomainResponsePayload::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Unlocks a domain to allow it to be transferred. **DEPRECATED** This endpoint is deprecated in favor of the new UpdateDomain API. This will be removed in a future release.
     *
     * Example:
     * ```php
     * $client->domains->unlockDomain(
     *     'domainName',
     *     new UnlockDomainRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain name to unlock.
     * @param UnlockDomainRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Domain
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function unlockDomain(string $domainName, UnlockDomainRequest $request, ?array $options = null): ?Domain
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}:unlock",
                    method: HttpMethod::POST,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Domain::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Checks whether up to 50 domain names are purchasable and returns **discovery** pricing for each result.
     *
     * **Discovery endpoint:** Returns `SearchResult` fields — `purchaseType`, `purchasePrice`, `premium`, `purchasable`. [Search](/api/v1/reference/domains/search) returns the same fields for keyword/suggestion flows. Use this endpoint to determine what to send on [Create Domain](/api/v1/reference/domains/create-domain).
     *
     * When results show `premium: true` or a non-`registration` `purchaseType`, follow the [Domain pricing guide](/guides/domain-pricing) before calling Create Domain. For non-registration types, re-check Check Availability immediately before create — acquisition prices can change.
     *
     * **Recommendation:** Set `purchaseType` to `registration`. Most resellers
     * restrict results to domains with a `purchaseType` of `registration`
     * to ensure predictable pricing and immediate fulfillment. Other purchase types
     * (such as aftermarket variants) can introduce higher costs and non-instant
     * transactions that may be delayed or declined by third parties.
     *
     * Example:
     * ```php
     * $client->domains->checkAvailability(
     *     new AvailabilityRequest([
     *         'domainNames' => [
     *             'domainNames',
     *         ],
     *     ]),
     * );
     * ```
     *
     * @param AvailabilityRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?SearchResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function checkAvailability(AvailabilityRequest $request, ?array $options = null): ?SearchResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains:checkAvailability",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return SearchResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Searches for domain name suggestions based on a keyword or term. Important: Do not
     * encode the `:` in the path. Use `/core/v1/domains:search`, not `/core/v1/domains%3Asearch`.
     *
     * **Discovery endpoint:** Returns `SearchResult` fields — `purchaseType`, `purchasePrice`, `premium`, `purchasable`.
     *
     * **Recommendation:** Set `purchaseType` to `registration`. Most resellers restrict
     * results to domains with a `purchaseType` of `registration` to ensure predictable
     * pricing and immediate fulfillment. Other purchase types (such as aftermarket) can
     * introduce higher costs and non-instant transactions that may be delayed or declined
     * by third parties.
     * With `purchaseType: registration`, domains that do not match the filter are **omitted** from results (unlike Check Availability, which returns them with `purchasable: false`).
     *
     * When results show `premium: true` or a non-`registration` `purchaseType`, follow the [Domain pricing guide](/guides/domain-pricing) before calling Create Domain. For all types, re-check with Check Availability immediately before create — prices and availability can change.
     *
     * Example:
     * ```php
     * $client->domains->search(
     *     new SearchRequest([
     *         'keyword' => 'mydomain',
     *     ]),
     * );
     * ```
     *
     * @param SearchRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?SearchResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function search(SearchRequest $request, ?array $options = null): ?SearchResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains:search",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return SearchResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Zone Check offers a rapid, preliminary check for domain availability by leveraging cached zone file data.  Ideal for large-batch queries, it provides a high confidence indication of a domain's availability significantly faster than live registry checks.  For definitive, real-time availability and pricing, you can follow up with the standard [Check Availability](/api/v1/reference/domains/check-availability) call.
     * The API normalizes and validates each submitted domain string. Domains that fail validation, use an unsupported TLD for this service, or  are otherwise not eligible for zone check are **removed** from the request before the zone file lookup runs. The response includes **only**  a numeric count of removed domains (`removed`); individual removed strings are not returned. A future API version may extend the contract to  include details about removed domains.
     *
     * For the best results and to avoid `400 Bad Request` errors after cleaning, ensure each domain string meets the criteria described for  `domainNames` in the request body schema.
     *
     * If no valid domains remain after this process, the API returns a `400 Bad Request` response.
     * **Note:** The cached zone files used for this check are refreshed twice daily based on the latest available data from the registries.
     *
     * Example:
     * ```php
     * $client->domains->zoneCheck(
     *     new ZoneCheckRequest([
     *         'domainNames' => [
     *             'example.com',
     *             'example.net',
     *             'example.org',
     *         ],
     *     ]),
     * );
     * ```
     *
     * @param ZoneCheckRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ZoneCheckResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function zoneCheck(ZoneCheckRequest $request, ?array $options = null): ?ZoneCheckResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/zonecheck",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return ZoneCheckResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new NamecomException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new NamecomException(message: $e->getMessage(), previous: $e);
        }
        throw new NamecomApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}
