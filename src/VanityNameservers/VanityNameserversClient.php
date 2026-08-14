<?php

namespace Namecom\VanityNameservers;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\VanityNameservers\Requests\ListVanityNameserversRequest;
use Namecom\Types\ListVanityNameserversResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\VanityNameservers\Requests\CreateVanityNameserverBody;
use Namecom\Types\VanityNameserverResponse;
use Namecom\VanityNameservers\Requests\UpdateVanityNameserverBody;

class VanityNameserversClient
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
     * Lists all vanity nameserver hostnames configured for a domain.
     *
     * Example:
     * ```php
     * $client->vanityNameservers->listVanityNameservers(
     *     'example.com',
     *     new ListVanityNameserversRequest([
     *         'perPage' => 50,
     *         'page' => 2,
     *     ]),
     * );
     * ```
     *
     * @param string $domainName The domain name to list vanity nameservers for.
     * @param ListVanityNameserversRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListVanityNameserversResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listVanityNameservers(string $domainName, ListVanityNameserversRequest $request = new ListVanityNameserversRequest(), ?array $options = null): ?ListVanityNameserversResponse
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
                    path: "core/v1/domains/{$domainName}/vanity_nameservers",
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
                return ListVanityNameserversResponse::fromJson($json);
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
     * Register a new vanity nameserver for the specified domain.
     *
     * Example:
     * ```php
     * $client->vanityNameservers->createVanityNameserver(
     *     'example.com',
     *     new CreateVanityNameserverBody([
     *         'hostname' => 'ns1',
     *         'ips' => [
     *             '192.168.1.10',
     *             '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
     *         ],
     *     ]),
     * );
     * ```
     *
     * @param string $domainName The domain name to create a vanity nameserver for.
     * @param CreateVanityNameserverBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?VanityNameserverResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createVanityNameserver(string $domainName, CreateVanityNameserverBody $request, ?array $options = null): ?VanityNameserverResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/vanity_nameservers",
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
                return VanityNameserverResponse::fromJson($json);
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
     * Retrieves details for a of a specific vanity nameserver (including its IP addresses).
     *
     * Example:
     * ```php
     * $client->vanityNameservers->getVanityNameserver(
     *     'example.com',
     *     'ns1.example.com',
     * );
     * ```
     *
     * @param string $domainName The domain name associated with the vanity nameserver.
     * @param string $hostname The hostname of the vanity nameserver to retrieve.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?VanityNameserverResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getVanityNameserver(string $domainName, string $hostname, ?array $options = null): ?VanityNameserverResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/vanity_nameservers/{$hostname}",
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
                return VanityNameserverResponse::fromJson($json);
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
     * Updates the glue record IP addresses for a vanity nameserver.
     *
     * Example:
     * ```php
     * $client->vanityNameservers->updateVanityNameserver(
     *     'example.com',
     *     'ns1.example.com',
     *     new UpdateVanityNameserverBody([]),
     * );
     * ```
     *
     * @param string $domainName The domain name associated with the vanity nameserver.
     * @param string $hostname The hostname of the vanity nameserver to update.
     * @param UpdateVanityNameserverBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?VanityNameserverResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function updateVanityNameserver(string $domainName, string $hostname, UpdateVanityNameserverBody $request = new UpdateVanityNameserverBody(), ?array $options = null): ?VanityNameserverResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/vanity_nameservers/{$hostname}",
                    method: HttpMethod::PUT,
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
                return VanityNameserverResponse::fromJson($json);
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
     * Deletes a vanity nameserver from the domain’s registry settings. This operation might fail if the registry detects the nameserver is still in use.
     *
     * Example:
     * ```php
     * $client->vanityNameservers->deleteVanityNameserver(
     *     'example.com',
     *     'ns1.example.com',
     * );
     * ```
     *
     * @param string $domainName The domain name associated with the vanity nameserver.
     * @param string $hostname The hostname of the vanity nameserver to delete.
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
    public function deleteVanityNameserver(string $domainName, string $hostname, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/vanity_nameservers/{$hostname}",
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
}
