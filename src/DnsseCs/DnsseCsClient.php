<?php

namespace Namecom\DnsseCs;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Types\ListDnsseCsResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\DnsseCs\Requests\CreateDnssecBody;
use Namecom\Types\Dnssec;

class DnsseCsClient
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
     * Lists all DNSSEC (DS) records configured for a domain.
     *
     * @param string $domainName DomainName is the domain name to list keys for.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListDnsseCsResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listDnsseCs(string $domainName, ?array $options = null): ?ListDnsseCsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/dnssec",
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
                return ListDnsseCsResponse::fromJson($json);
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
     * Adds (registers) a new DNSSEC DS record for a domain.
     *
     * @param string $domainName DomainName is the domain name to create keys for.
     * @param CreateDnssecBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Dnssec
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createDnssec(string $domainName, CreateDnssecBody $request, ?array $options = null): ?Dnssec
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/dnssec",
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
                return Dnssec::fromJson($json);
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
     * Retrieves details of a specific DNSSEC record for a domain.
     *
     * @param string $domainName DomainName is the domain name.
     * @param string $digest Digest is the digest for the DNSKEY RR to retrieve.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Dnssec
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getDnssec(string $domainName, string $digest, ?array $options = null): ?Dnssec
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/dnssec/{$digest}",
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
                return Dnssec::fromJson($json);
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
     * Deletes a DNSSEC record from a domain.
     *
     * @param string $domainName DomainName is the domain name the key is registered for.
     * @param string $digest Digest is the digest for the DNSKEY RR to remove from the registry.
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
    public function deleteDnssec(string $domainName, string $digest, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/dnssec/{$digest}",
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
