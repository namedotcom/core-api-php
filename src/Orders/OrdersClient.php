<?php

namespace Namecom\Orders;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\Orders\Requests\ListOrdersRequest;
use Namecom\Types\ListOrdersResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Namecom\Types\Order;

class OrdersClient
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
     * Retrieves a list of all orders placed in the account.
     *
     * Example:
     * ```php
     * $client->orders->listOrders(
     *     new ListOrdersRequest([]),
     * );
     * ```
     *
     * @param ListOrdersRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ListOrdersResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function listOrders(ListOrdersRequest $request = new ListOrdersRequest(), ?array $options = null): ?ListOrdersResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->perPage != null) {
            $query['perPage'] = $request->perPage;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->dir != null) {
            $query['dir'] = $request->dir;
        }
        if ($request->domainName != null) {
            $query['domainName'] = $request->domainName;
        }
        if ($request->tld != null) {
            $query['tld'] = $request->tld;
        }
        if ($request->createDateStart != null) {
            $query['createDateStart'] = $request->createDateStart;
        }
        if ($request->createDateEnd != null) {
            $query['createDateEnd'] = $request->createDateEnd;
        }
        if ($request->type != null) {
            $query['type'] = $request->type;
        }
        if ($request->orderStatus != null) {
            $query['orderStatus'] = $request->orderStatus;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/orders",
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
                return ListOrdersResponse::fromJson($json);
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
     * Fetches full details about a specific order using its ID. This includes domains, prices, and timestamps.  Useful for confirming transactions, receipts, or generating invoices.
     *
     * Example:
     * ```php
     * $client->orders->getOrder(
     *     1,
     * );
     * ```
     *
     * @param int $orderId OrderId is the unique identifier of the requested order.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Order
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function getOrder(int $orderId, ?array $options = null): ?Order
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/orders/{$orderId}",
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
                return Order::fromJson($json);
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
