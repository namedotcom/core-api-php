<?php

namespace Namecom\Transfers;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Transfers\Requests\ListTransfersRequest;
use Namecom\Types\ListTransfersResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\Transfers\Requests\CreateTransferRequest;
use Namecom\Types\CreateTransferResponse;
use Namecom\Types\Transfer;
use Namecom\Transfers\Requests\CancelTransferRequest;
use Namecom\Transfers\Requests\CancelOutboundTransferRequest;
use Namecom\Types\CancelTransferOutResponse;
use Namecom\Transfers\Requests\CreateInternalTransferInRequest;
use Namecom\Types\DomainResponsePayload;
use Namecom\Types\TransferEligibilityResponse;

class TransfersClient
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
     * Returns all domain transfer requests for the account, including in-progress and recent transfers.
     *
     * Example:
     * ```php
     * $client->transfers->listTransfers(
     *     new ListTransfersRequest([]),
     * );
     * ```
     *
     * @param ListTransfersRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListTransfersResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listTransfers(ListTransfersRequest $request = new ListTransfersRequest(), ?array $options = null): ?ListTransfersResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->perPage != null) {
            $query['perPage'] = $request->perPage;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/transfers",
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
                return ListTransfersResponse::fromJson($json);
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
     * Initiates a domain transfer into your name.com account from another registrar. You must provide the domain name and its valid transfer authorization code (EPP code). The domain must not be locked or under any transfer restrictions (e.g. clientTransferProhibited). If successful, the transfer is submitted and tracked through the ICANN transfer process. Once a transfer has been created, you can track its progress via the [GetTransfer](/api/v1/reference/transfers/get-transfer) endpoint.
     * **Transfer pricing:** Omit `purchasePrice` for standard (non-premium) transfers. For premium transfers, pass `transferPrice` from [Get Pricing For Domain](/api/v1/reference/domains/get-pricing-for-domain) as `purchasePrice`. If sent, it must match Get Pricing `transferPrice` exactly or the request will fail. Premium transfers without `purchasePrice` will fail. See the [Domain pricing guide](/guides/domain-pricing) for how [Get Pricing](/api/v1/reference/domains/get-pricing-for-domain) `transferPrice` relates to the `years` query parameter.
     *
     * Example:
     * ```php
     * $client->transfers->createTransfer(
     *     new CreateTransferRequest([
     *         'authCode' => 'ABC123',
     *         'domainName' => 'example.com',
     *     ]),
     * );
     * ```
     *
     * @param CreateTransferRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?CreateTransferResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createTransfer(CreateTransferRequest $request, ?array $options = null): ?CreateTransferResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/transfers",
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
                return CreateTransferResponse::fromJson($json);
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
     * Retrieves details of a specific domain transfer request.
     *
     * Example:
     * ```php
     * $client->transfers->getTransfer(
     *     'domainName',
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain you want to get the transfer information for.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Transfer
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getTransfer(string $domainName, ?array $options = null): ?Transfer
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/transfers/{$domainName}",
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
                return Transfer::fromJson($json);
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
     * Cancels a pending transfer request. This can be used if the transfer was initiated in error or if the authorization code provided was incorrect.
     * The price of the transfer will refund the amount to account credit.
     *
     * Cancelable statuses:
     * - pending
     * - submitting_transfer
     * - pending_new_auth_code
     * - pending_unlock
     * - pending_registry_unlock
     * - rejected
     *
     * Non-cancelable statuses:
     * - pending_transfer
     * - pending_insert
     * - completed
     * - failed
     * - canceled
     * - canceled_pending_refund
     *
     * Example:
     * ```php
     * $client->transfers->cancelTransfer(
     *     'domainName',
     *     new CancelTransferRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to cancel the transfer for.
     * @param CancelTransferRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Transfer
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function cancelTransfer(string $domainName, CancelTransferRequest $request, ?array $options = null): ?Transfer
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/transfers/{$domainName}:cancel",
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
                return Transfer::fromJson($json);
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
     * Cancels an outbound transfer for the given domain. Use this when the domain is being transferred out of name.com (losing registrar) to another (gaining) registrar and the registrant or reseller wants to cancel that transfer.
     * On success, subscribers receive `domain.transfer_out.status_change` with status `canceled`.
     * The endpoint validates that the domain exists and belongs to the authenticated account. Only domains in a pending transfer (out) state can be canceled.
     *
     * Example:
     * ```php
     * $client->transfers->cancelOutboundTransfer(
     *     'example.com',
     *     new CancelOutboundTransferRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain whose transfer out should be canceled.
     * @param CancelOutboundTransferRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?CancelTransferOutResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function cancelOutboundTransfer(string $domainName, CancelOutboundTransferRequest $request, ?array $options = null): ?CancelTransferOutResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/transfers/external/out/{$domainName}:cancel",
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
                return CancelTransferOutResponse::fromJson($json);
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
     * Pulls a domain from another [name.com](https://www.name.com) account into your reseller (gaining) account using a valid authorization code. This is an **internal** name.com-to-name.com move; it is separate from [Create Transfer](/api/v1/reference/transfers/create-transfer), which brings domains in from **external** registrars.
     * Check if a TLD is eligible for internal transfer in by calling [Tld Requirements](/api/v1/reference/domaininfo/requirementsV2) for the TLD and checking property `supportsInternalTransfer`.
     * This API is only available to approved reseller accounts. Contact name.com support to request access.
     * #### Losing account (dashboard only)
     * The party that holds the domain today must use the name.com dashboard on the **losing** account to **unlock** the domain (remove registrar transfer lock) and to **copy the authorization code** to provide to your integration. This endpoint does not unlock the domain or retrieve the auth code for the losing account.
     * #### Gaining account (this API)
     * Call this endpoint with `domainName`, `authCode`, and optional `contacts` using the **gaining** reseller's API credentials.
     * #### Contacts and post-transfer lock
     * If `contacts` is omitted, the gaining account's default contacts are applied. If `contacts` is provided, any roles included in the request are applied and omitted roles use the gaining account's default contacts (same pattern as [Create Domain](/api/v1/reference/domains/create-domain) and [Set Contacts](/api/v1/reference/domains/set-contacts)). The 60-day contact-change transfer lock is enforced based on the **gaining** account's settings, consistent with Set Contacts.
     * #### Access
     * Restricted to approved enterprise resellers; other callers receive `403 Forbidden`.
     *
     * Example:
     * ```php
     * $client->transfers->createInternalTransferIn(
     *     new CreateInternalTransferInRequest([
     *         'domainName' => 'example.com',
     *         'authCode' => 'ABC123',
     *     ]),
     * );
     * ```
     *
     * @param CreateInternalTransferInRequest $request
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
    public function createInternalTransferIn(CreateInternalTransferInRequest $request, ?array $options = null): ?DomainResponsePayload
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/transfers/internal/in",
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
     * Returns whether a domain is currently registered at [name.com](https://www.name.com) and whether the TLD supports internal transfer between name.com accounts. Use this to decide whether to send your user through the [Create Transfer](/api/v1/reference/transfers/create-transfer) external transfer flow or the [Create Internal Transfer In](/api/v1/reference/transfers/create-internal-transfer-in) flow before initiating a transfer-in.
     *
     * #### Response semantics
     *
     * `atName` is `true` if the domain is currently registered at name.com in any account. This information is also publicly available via RDAP.
     *
     * `supportsInternalTransfer` mirrors the TLD-level value returned by [Tld Requirements](/api/v1/reference/domain-info/get-specific-tld-requirements). It indicates whether the TLD is eligible for internal transfer between name.com accounts. It does not reflect per-account allowlist eligibility — if your account is not allowlisted for internal transfer in, calling [Create Internal Transfer In](/api/v1/reference/transfers/create-internal-transfer-in) will return `403 Forbidden`.
     *
     * #### Privacy
     *
     * This endpoint never reveals which account a domain is in. To check whether a domain is in your own account, use [Get Domain](/api/v1/reference/domains/get-domain) instead.
     *
     * Example:
     * ```php
     * $client->transfers->getTransferEligibility(
     *     'domainName',
     * );
     * ```
     *
     * @param string $domainName The domain to check transfer eligibility for. Punycode is normalized server-side, so either ASCII or UTF-8 is accepted.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?TransferEligibilityResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getTransferEligibility(string $domainName, ?array $options = null): ?TransferEligibilityResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/transfers/eligibility/{$domainName}",
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
                return TransferEligibilityResponse::fromJson($json);
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
