<?php

namespace Namecom\UrlForwardings;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\UrlForwardings\Requests\ListUrlForwardingsRequest;
use Namecom\Types\ListUrlForwardingsResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\UrlForwardings\Requests\CreateUrlForwardingRequest;
use Namecom\Types\UrlForwardingResponse;
use Namecom\UrlForwardings\Requests\UpdateUrlForwardingRequest;
use Namecom\UrlForwardings\Requests\ListUrlForwardingsByDomainRequest;
use Namecom\UrlForwardings\Requests\UpdateUrlForwardingByIdRequest;

class UrlForwardingsClient
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
     * Returns all URL forwarding settings configured for a domain. **Deprecated.** Use [List URL Forwardings by domain](/api/v1/reference/url-forwardings/list-urlforwardings-by-domain) instead, which returns entries with an `id` for use with by-ID endpoints.
     *
     * Example:
     * ```php
     * $client->urlForwardings->listUrlForwardings(
     *     'example.com',
     *     new ListUrlForwardingsRequest([
     *         'perPage' => 100,
     *         'page' => 1,
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to list URL forwarding entries for.
     * @param ListUrlForwardingsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListUrlForwardingsResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listUrlForwardings(string $domainName, ListUrlForwardingsRequest $request = new ListUrlForwardingsRequest(), ?array $options = null): ?ListUrlForwardingsResponse
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
                    path: "core/v1/domains/{$domainName}/url/forwarding",
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
                return ListUrlForwardingsResponse::fromJson($json);
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
     * Sets up a new URL forwarding (redirect) for a domain or subdomain. If this is the first URL forwarding entry, it may modify the A records for the domain accordingly. Note that changes may take up to 24 hours to fully propagate.
     *
     * Example:
     * ```php
     * $client->urlForwardings->createUrlForwarding(
     *     'example.com',
     *     new CreateUrlForwardingRequest([
     *         'body' => new UrlForwardingInput([
     *             'forwardsTo' => 'https://destination-site.com',
     *             'host' => 'www',
     *             'type' => UrlForwardingInputType::Masked->value,
     *         ]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain part of the hostname to forward.
     * @param CreateUrlForwardingRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?UrlForwardingResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createUrlForwarding(string $domainName, CreateUrlForwardingRequest $request, ?array $options = null): ?UrlForwardingResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/url/forwarding",
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
                return UrlForwardingResponse::fromJson($json);
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
     * Retrieves the details of a specific URL forwarding configuration. **Deprecated.** Use [Get URL Forwarding by ID](/api/v1/reference/url-forwardings/get-urlforwarding-by-id) instead.
     *
     * Example:
     * ```php
     * $client->urlForwardings->getUrlForwarding(
     *     'example.com',
     *     'www.example.org',
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to get the URL forwarding entry for.
     * @param string $host The full hostname, including subdomain.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?UrlForwardingResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getUrlForwarding(string $domainName, string $host, ?array $options = null): ?UrlForwardingResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/url/forwarding/{$host}",
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
                return UrlForwardingResponse::fromJson($json);
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
     * Modifies an existing URL forwarding rule. Changes may take up to 24 hours to fully propagate. **Deprecated.** Use [Update URL Forwarding by ID](/api/v1/reference/url-forwardings/update-urlforwarding-by-id) instead.
     *
     * Example:
     * ```php
     * $client->urlForwardings->updateUrlForwarding(
     *     'example.com',
     *     'www.example.org',
     *     new UpdateUrlForwardingRequest([
     *         'body' => new UrlForwardingInput([
     *             'forwardsTo' => 'https://destination-site.com',
     *             'host' => 'www',
     *             'type' => UrlForwardingInputType::Masked->value,
     *         ]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain part of the hostname to forward.
     * @param string $host The full hostname, including subdomain.
     * @param UpdateUrlForwardingRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?UrlForwardingResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function updateUrlForwarding(string $domainName, string $host, UpdateUrlForwardingRequest $request, ?array $options = null): ?UrlForwardingResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/url/forwarding/{$host}",
                    method: HttpMethod::PUT,
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
                return UrlForwardingResponse::fromJson($json);
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
     * Removes a URL forwarding configuration from the domain. This operation cannot be undone. **Deprecated.** Use [Delete URL Forwarding by ID](/api/v1/reference/url-forwardings/delete-urlforwarding-by-id) instead.
     *
     * Example:
     * ```php
     * $client->urlForwardings->deleteUrlForwarding(
     *     'example.com',
     *     'www.example.org',
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to delete the URL forwarding entry from.
     * @param string $host The full hostname, including subdomain.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function deleteUrlForwarding(string $domainName, string $host, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/url/forwarding/{$host}",
                    method: HttpMethod::DELETE,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                return;
            }
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
     * Returns all URL forwarding settings configured for a domain. Each entry includes an `id` that can be used with the URL Forwarding by-ID endpoints to get, update, or delete records.
     *
     * Example:
     * ```php
     * $client->urlForwardings->listUrlForwardingsByDomain(
     *     'example.com',
     *     new ListUrlForwardingsByDomainRequest([
     *         'perPage' => 100,
     *         'page' => 1,
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to list URL forwarding entries for. The domain must be owned by the authenticated account.
     * @param ListUrlForwardingsByDomainRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListUrlForwardingsResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listUrlForwardingsByDomain(string $domainName, ListUrlForwardingsByDomainRequest $request = new ListUrlForwardingsByDomainRequest(), ?array $options = null): ?ListUrlForwardingsResponse
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
                    path: "core/v1/urlforwarding/{$domainName}",
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
                return ListUrlForwardingsResponse::fromJson($json);
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
     * Retrieves the details of a specific URL forwarding configuration by ID.  The domain must be owned by the authenticated account.
     *
     * Example:
     * ```php
     * $client->urlForwardings->getUrlForwardingById(
     *     'example.com',
     *     12345,
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain that owns the URL forwarding entry. Must be owned by the authenticated account.
     * @param int $id ID is the server-assigned unique identifier for the URL forwarding record (returned in list responses).
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?UrlForwardingResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getUrlForwardingById(string $domainName, int $id, ?array $options = null): ?UrlForwardingResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/urlforwarding/{$domainName}/{$id}",
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
                return UrlForwardingResponse::fromJson($json);
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
     * Removes a URL forwarding configuration by ID. The domain must be owned by the authenticated account. This operation cannot be undone.
     *
     * Example:
     * ```php
     * $client->urlForwardings->deleteUrlForwardingById(
     *     'example.com',
     *     12345,
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain that owns the URL forwarding entry. Must be owned by the authenticated account.
     * @param int $id ID is the server-assigned unique identifier for the URL forwarding record (returned in list responses).
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function deleteUrlForwardingById(string $domainName, int $id, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/urlforwarding/{$domainName}/{$id}",
                    method: HttpMethod::DELETE,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                return;
            }
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
     * Modifies an existing URL forwarding rule by ID.  The domain must be owned by the authenticated account. Changes may take up to 24 hours to fully propagate.
     *
     * Example:
     * ```php
     * $client->urlForwardings->updateUrlForwardingById(
     *     'example.com',
     *     12345,
     *     new UpdateUrlForwardingByIdRequest([
     *         'body' => new UrlForwardingInput([
     *             'forwardsTo' => 'https://destination-site.com',
     *             'host' => 'www',
     *             'type' => UrlForwardingInputType::Masked->value,
     *         ]),
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain that owns the URL forwarding entry. Must be owned by the authenticated account.
     * @param int $id ID is the server-assigned unique identifier for the URL forwarding record (returned in list responses).
     * @param UpdateUrlForwardingByIdRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?UrlForwardingResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function updateUrlForwardingById(string $domainName, int $id, UpdateUrlForwardingByIdRequest $request, ?array $options = null): ?UrlForwardingResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/urlforwarding/{$domainName}/{$id}",
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
                return UrlForwardingResponse::fromJson($json);
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
