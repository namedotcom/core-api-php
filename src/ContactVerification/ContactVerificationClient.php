<?php

namespace Namecom\ContactVerification;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\ContactVerification\Requests\UnverifiedContactsListRequest;
use Namecom\Types\UnverifiedContactsResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\ContactVerification\Requests\VerifyContactRequest;
use Namecom\ContactVerification\Requests\ResendContactVerificationEmailRequest;
use Namecom\Types\ContactVerificationResendResponse;

class ContactVerificationClient
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
     * Returns a list of contacts, related to domains within your account, that require verification as per ICANN procedures.
     * When a new domain is created, unverified contacts are not immediately available in API responses.  Records are added by a scheduled process that runs approximately every 10 minutes.  As a result, there may be up to a 10-minute delay before unverified contacts appear in the API. This delay also applies to related events such as webhooks or other downstream systems that depend on contact verification data.
     *
     * Example:
     * ```php
     * $client->contactVerification->unverifiedContactsList(
     *     new UnverifiedContactsListRequest([
     *         'perPage' => 100,
     *         'page' => 2,
     *     ]),
     * );
     * ```
     *
     * @param UnverifiedContactsListRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?UnverifiedContactsResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function unverifiedContactsList(UnverifiedContactsListRequest $request = new UnverifiedContactsListRequest(), ?array $options = null): ?UnverifiedContactsResponse
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
                    path: "core/v1/contacts/unverified",
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
                return UnverifiedContactsResponse::fromJson($json);
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
     * Use this API to verify a contact.
     * This API is only available to approved reseller accounts. Contact name.com support to request access.
     *
     * Example:
     * ```php
     * $client->contactVerification->verifyContact(
     *     1,
     *     new VerifyContactRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param int $verificationId The VerificationId required to verify a specific contact.
     * @param VerifyContactRequest $request
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
    public function verifyContact(int $verificationId, VerifyContactRequest $request, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/contacts/verify/{$verificationId}",
                    method: HttpMethod::POST,
                    body: $request->body,
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
     * Resend the contact verification email for a pending verification record.
     *
     * ### Throttling
     * This endpoint enforces strict throttling to prevent abuse:
     * - Per `verificationId`: max 1 resend per 15 minutes
     * - Per reseller account: max 200 resends per rolling hour
     *
     * `nextEligibleAt` is always returned so the client knows when it can try again.
     *
     * On `429`, the response uses the standard error envelope, and `details` contains the earliest retry time (RFC3339 UTC).
     *
     * Example:
     * ```php
     * $client->contactVerification->resendContactVerificationEmail(
     *     1,
     *     new ResendContactVerificationEmailRequest([
     *         'body' => new EmptyObject([]),
     *     ]),
     * );
     * ```
     *
     * @param int $verificationId The verificationId for the pending contact verification record.
     * @param ResendContactVerificationEmailRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ContactVerificationResendResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function resendContactVerificationEmail(int $verificationId, ResendContactVerificationEmailRequest $request, ?array $options = null): ?ContactVerificationResendResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/contacts/verify/{$verificationId}:resend",
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
                return ContactVerificationResendResponse::fromJson($json);
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
