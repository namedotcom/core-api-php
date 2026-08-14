<?php

namespace Namecom\EmailForwardings;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\EmailForwardings\Requests\ListEmailForwardingsRequest;
use Namecom\Types\ListEmailForwardingsResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\EmailForwardings\Requests\CreateEmailForwardingRequest;
use Namecom\Types\EmailForwarding;
use Namecom\EmailForwardings\Requests\EmailForwardingsUpdateEmailForwardingBody;

class EmailForwardingsClient
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
     * Returns a paginated list of all email forwarding rules for a domain.
     *
     * Example:
     * ```php
     * $client->emailForwardings->listEmailForwardings(
     *     'domainName',
     *     new ListEmailForwardingsRequest([
     *         'perPage' => 100,
     *         'page' => 1,
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to list email forwarded boxes for.
     * @param ListEmailForwardingsRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListEmailForwardingsResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listEmailForwardings(string $domainName, ListEmailForwardingsRequest $request = new ListEmailForwardingsRequest(), ?array $options = null): ?ListEmailForwardingsResponse
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
                    path: "core/v1/domains/{$domainName}/email/forwarding",
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
                return ListEmailForwardingsResponse::fromJson($json);
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
     * Creates a new email forwarding rule for a domain, such as redirecting info@example.com to an external inbox.  If this is the first email forwarding rule created for the domain, the API may also update your MX records automatically to enable mail routing.  The alias must not conflict with existing email services or MX records.  To modify a forwarding rule later, use [UpdateEmailForwarding](/api/v1/reference/email-forwardings/update-email-forwarding).
     *
     * Example:
     * ```php
     * $client->emailForwardings->createEmailForwarding(
     *     'example.com',
     *     new CreateEmailForwardingRequest([
     *         'emailBox' => 'admin',
     *         'emailTo' => 'webmaster@example.com',
     *     ]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain part of the email address to forward.
     * @param CreateEmailForwardingRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?EmailForwarding
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createEmailForwarding(string $domainName, CreateEmailForwardingRequest $request, ?array $options = null): ?EmailForwarding
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/email/forwarding",
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
                return EmailForwarding::fromJson($json);
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
     * Retrieves the details of a specific email forwarding entry.
     *
     * Example:
     * ```php
     * $client->emailForwardings->getEmailForwarding(
     *     'domainName',
     *     'emailBox',
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to list email forwarded box for.
     * @param string $emailBox EmailBox is which email box to retrieve.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?EmailForwarding
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getEmailForwarding(string $domainName, string $emailBox, ?array $options = null): ?EmailForwarding
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/email/forwarding/{$emailBox}",
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
                return EmailForwarding::fromJson($json);
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
     * Updates the destination email address for an existing forwarding rule.
     *
     * Example:
     * ```php
     * $client->emailForwardings->updateEmailForwarding(
     *     'domainName',
     *     'emailBox',
     *     new EmailForwardingsUpdateEmailForwardingBody([]),
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain part of the email address to forward.
     * @param string $emailBox EmailBox is the user portion of the email address to forward.
     * @param EmailForwardingsUpdateEmailForwardingBody $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?EmailForwarding
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function updateEmailForwarding(string $domainName, string $emailBox, EmailForwardingsUpdateEmailForwardingBody $request = new EmailForwardingsUpdateEmailForwardingBody(), ?array $options = null): ?EmailForwarding
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/email/forwarding/{$emailBox}",
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
                return EmailForwarding::fromJson($json);
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
     * Deletes an email forwarding rule from a domain.
     *
     * Example:
     * ```php
     * $client->emailForwardings->deleteEmailForwarding(
     *     'domainName',
     *     'emailBox',
     * );
     * ```
     *
     * @param string $domainName DomainName is the domain to delete the email forwarded box from.
     * @param string $emailBox EmailBox is which email box to delete.
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
    public function deleteEmailForwarding(string $domainName, string $emailBox, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/domains/{$domainName}/email/forwarding/{$emailBox}",
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
