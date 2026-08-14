<?php

namespace Namecom\Refunds;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Refunds\Requests\RefundRequest;
use Namecom\Types\RefundResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;

class RefundsClient
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
     * Deletes eligible domains and security products during the Add Grace Period (AGP) and automatically issues refunds for the associated order items.
     *
     * ### Eligibility Requirements
     *
     * - **Product Types**: Only `registration` and `whois_privacy` product types are eligible for refunds.
     * - **AGP Timing**: Items must be within the Add Grace Period (typically 5 days from registration, varies by TLD).
     * - **Order Ownership**: All `orderItemIds` must belong to the specified `orderId`.
     *
     * ### Refund Processing
     *
     * Refunds are processed in the following order:
     * 1. Domain deletion is attempted for each eligible order item
     * 2. Upon successful deletion, the refund is issued
     * 3. Refunds are sent to the original payment method on file
     * 4. If the original payment method is unavailable, the refund is credited to the account balance
     *
     * ### Idempotency
     *
     * This endpoint supports idempotent requests via the `X-Idempotency-Key` header. If you retry a request with the same idempotency key, you will receive the same response as the original request. This is useful for safely retrying requests without risk of processing duplicate refunds.
     *
     * Example:
     * ```php
     * $client->refunds->processRefund(
     *     new RefundRequest([
     *         'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
     *         'orderId' => 123456,
     *         'orderItemIds' => [
     *             987654,
     *         ],
     *     ]),
     * );
     * ```
     *
     * @param RefundRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?RefundResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function processRefund(RefundRequest $request, ?array $options = null): ?RefundResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        if ($request->idempotencyKey != null) {
            $headers['X-Idempotency-Key'] = $request->idempotencyKey;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/refund",
                    method: HttpMethod::POST,
                    headers: $headers,
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
                return RefundResponse::fromJson($json);
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
