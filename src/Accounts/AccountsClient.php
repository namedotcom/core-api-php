<?php

namespace Namecom\Accounts;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Accounts\Requests\CreateAccountRequest;
use Namecom\Types\CreateAccountResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;

class AccountsClient
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
     * Creates a new sub-account under your authenticated reseller account and returns API credentials for the new account.  This endpoint is only available to approved reseller accounts. Contact name.com support to request access.
     *
     * Example:
     * ```php
     * $client->accounts->createAccount(
     *     new CreateAccountRequest([
     *         'account' => new AccountRequest([
     *             'contacts' => new ContactsRequest([
     *                 'registrant' => new RegistrantContactRequest([
     *                     'firstName' => 'Jane',
     *                     'lastName' => 'Doe',
     *                     'address1' => '123 Main St.',
     *                     'city' => 'Denver',
     *                     'state' => 'CO',
     *                     'zip' => '12345',
     *                     'country' => 'US',
     *                     'email' => 'admin@example.net',
     *                     'phone' => '+13035551212',
     *                 ]),
     *             ]),
     *             'accountName' => 'reseller_subaccount',
     *             'password' => 'SecureP4ss!',
     *         ]),
     *         'apiTos' => true,
     *         'tos' => true,
     *     ]),
     * );
     * ```
     *
     * @param CreateAccountRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?CreateAccountResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function createAccount(CreateAccountRequest $request, ?array $options = null): ?CreateAccountResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/accounts",
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
                return CreateAccountResponse::fromJson($json);
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
