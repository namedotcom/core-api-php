<?php

namespace Namecom\Dns;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Dns\Requests\ListRecordsRequest;
use Namecom\Types\ListRecordsResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\Dns\Requests\DnsCreateRecordBody;
use Namecom\Types\Record;
use Namecom\Dns\Requests\DnsUpdateRecordBody;

class DnsClient
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
     * Lists all DNS records for a specified domain.
     *
     * Example:
     * ```php
     * $client->dns->listRecords(
     *     'domainName',
     *     new ListRecordsRequest([]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the zone to list the records for.
     * @param ListRecordsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListRecordsResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listRecords(string $domainName, ListRecordsRequest $request = new ListRecordsRequest(), ?array $options = null): ?ListRecordsResponse
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
                    path: "core/v1/domains/{$domainName}/records",
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
                return ListRecordsResponse::fromJson($json);
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
     * Adds a new DNS record to the specified domain zone. Provide the record type (e.g. A, MX, CNAME), host, value, and TTL.  This is used for configuring domain-based services such as email, website hosting, or third-party verifications.
     *
     * Example:
     * ```php
     * $client->dns->createRecord(
     *     'domainName',
     *     new DnsCreateRecordBody([
     *         'answer' => 'answer',
     *         'host' => 'host',
     *         'type' => DnsCreateRecordBodyType::A->value,
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the zone that the record belongs to.
     * @param DnsCreateRecordBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Record
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createRecord(string $domainName, DnsCreateRecordBody $request, ?array $options = null): ?Record
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/records",
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
                return Record::fromJson($json);
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
     * Retrieves details of a specific DNS record.
     *
     * Example:
     * ```php
     * $client->dns->getRecord(
     *     'domainName',
     *     1,
     * );
     * ```
     *
     * @param string $domainName DomainName is the zone the record exists in.
     * @param int $id ID is the server-assigned unique identifier for this record.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Record
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getRecord(string $domainName, int $id, ?array $options = null): ?Record
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/records/{$id}",
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
                return Record::fromJson($json);
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
     * Replaces an existing DNS record with new data. This is a full overwrite — all required fields (host, type, answer, ttl) must be included in the request body. If you omit a field, the existing value will not be preserved and the request may fail. Use [GetRecord](/api/v1/reference/dns/get-record) beforehand to retrieve the current values if you intend to modify just one field. The record ID must belong to a domain you manage.
     *
     * Example:
     * ```php
     * $client->dns->updateRecord(
     *     'domainName',
     *     1,
     *     new DnsUpdateRecordBody([
     *         'answer' => 'answer',
     *         'type' => DnsUpdateRecordBodyType::A->value,
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the zone that the record belongs to.
     * @param int $id Unique record id. Value is ignored on Create, and must match the URI on Update.
     * @param DnsUpdateRecordBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Record
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function updateRecord(string $domainName, int $id, DnsUpdateRecordBody $request, ?array $options = null): ?Record
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/records/{$id}",
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
                return Record::fromJson($json);
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
     * Removes a DNS record by ID. Often used during cleanup operations or when replacing outdated DNS settings with updated records.
     *
     * Example:
     * ```php
     * $client->dns->deleteRecord(
     *     'domainName',
     *     1,
     * );
     * ```
     *
     * @param string $domainName DomainName is the zone that the record to be deleted exists in.
     * @param int $id ID is the server-assigned unique identifier for the Record to be deleted. If the Record with that ID does not exist in the specified Domain, an error is returned.
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
    public function deleteRecord(string $domainName, int $id, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/records/{$id}",
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
