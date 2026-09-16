<?php

namespace Namecom;

use Namecom\AccountInfo\AccountInfoClient;
use Namecom\Accounts\AccountsClient;
use Namecom\Domains\DomainsClient;
use Namecom\DnsseCs\DnsseCsClient;
use Namecom\EmailForwardings\EmailForwardingsClient;
use Namecom\Dns\DnsClient;
use Namecom\UrlForwardings\UrlForwardingsClient;
use Namecom\VanityNameservers\VanityNameserversClient;
use Namecom\WebhookNotifications\WebhookNotificationsClient;
use Namecom\Orders\OrdersClient;
use Namecom\Refunds\RefundsClient;
use Namecom\Transfers\TransfersClient;
use Namecom\DomainInfo\DomainInfoClient;
use Namecom\TldPricing\TldPricingClient;
use Namecom\PremiumDomains\PremiumDomainsClient;
use Namecom\ContactVerification\ContactVerificationClient;
use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Types\HelloResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;

class NamecomClient
{
    /**
     * @var AccountInfoClient $accountInfo
     */
    public AccountInfoClient $accountInfo;

    /**
     * @var AccountsClient $accounts
     */
    public AccountsClient $accounts;

    /**
     * @var DomainsClient $domains
     */
    public DomainsClient $domains;

    /**
     * @var DnsseCsClient $dnsseCs
     */
    public DnsseCsClient $dnsseCs;

    /**
     * @var EmailForwardingsClient $emailForwardings
     */
    public EmailForwardingsClient $emailForwardings;

    /**
     * @var DnsClient $dns
     */
    public DnsClient $dns;

    /**
     * @var UrlForwardingsClient $urlForwardings
     */
    public UrlForwardingsClient $urlForwardings;

    /**
     * @var VanityNameserversClient $vanityNameservers
     */
    public VanityNameserversClient $vanityNameservers;

    /**
     * @var WebhookNotificationsClient $webhookNotifications
     */
    public WebhookNotificationsClient $webhookNotifications;

    /**
     * @var OrdersClient $orders
     */
    public OrdersClient $orders;

    /**
     * @var RefundsClient $refunds
     */
    public RefundsClient $refunds;

    /**
     * @var TransfersClient $transfers
     */
    public TransfersClient $transfers;

    /**
     * @var DomainInfoClient $domainInfo
     */
    public DomainInfoClient $domainInfo;

    /**
     * @var TldPricingClient $tldPricing
     */
    public TldPricingClient $tldPricing;

    /**
     * @var PremiumDomainsClient $premiumDomains
     */
    public PremiumDomainsClient $premiumDomains;

    /**
     * @var ContactVerificationClient $contactVerification
     */
    public ContactVerificationClient $contactVerification;

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
     * @param string $username The username to use for authentication.
     * @param string $password The password to use for authentication.
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        string $username,
        string $password,
        ?array $options = null,
    ) {
        $defaultHeaders = [
            'X-Fern-Language' => 'PHP',
            'X-Fern-SDK-Name' => 'Namecom',
            'X-Fern-SDK-Version' => '1.34.0',
            'User-Agent' => 'namecom/core-api/1.34.0',
        ];
        $defaultHeaders['Authorization'] = "Basic " . base64_encode($username . ":" . $password);

        $this->options = $options ?? [];

        $this->options['headers'] = array_merge(
            $defaultHeaders,
            $this->options['headers'] ?? [],
        );

        $this->client = new RawClient(
            options: $this->options,
        );

        $this->accountInfo = new AccountInfoClient($this->client, $this->options);
        $this->accounts = new AccountsClient($this->client, $this->options);
        $this->domains = new DomainsClient($this->client, $this->options);
        $this->dnsseCs = new DnsseCsClient($this->client, $this->options);
        $this->emailForwardings = new EmailForwardingsClient($this->client, $this->options);
        $this->dns = new DnsClient($this->client, $this->options);
        $this->urlForwardings = new UrlForwardingsClient($this->client, $this->options);
        $this->vanityNameservers = new VanityNameserversClient($this->client, $this->options);
        $this->webhookNotifications = new WebhookNotificationsClient($this->client, $this->options);
        $this->orders = new OrdersClient($this->client, $this->options);
        $this->refunds = new RefundsClient($this->client, $this->options);
        $this->transfers = new TransfersClient($this->client, $this->options);
        $this->domainInfo = new DomainInfoClient($this->client, $this->options);
        $this->tldPricing = new TldPricingClient($this->client, $this->options);
        $this->premiumDomains = new PremiumDomainsClient($this->client, $this->options);
        $this->contactVerification = new ContactVerificationClient($this->client, $this->options);
    }

    /**
     * Returns basic information about the API server (useful for testing connectivity and version checks).
     *
     * Example:
     * ```php
     * $client->hello();
     * ```
     *
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?HelloResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function hello(?array $options = null): ?HelloResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/hello",
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
                return HelloResponse::fromJson($json);
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
