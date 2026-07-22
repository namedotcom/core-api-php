<?php

namespace Namecom\TldPricing;

use Psr\Http\Client\ClientInterface;
use Namecom\Core\Client\RawClient;
use Namecom\TldPricing\Requests\TldPriceListRequest;
use Namecom\Types\TldPriceListResponse;
use Namecom\Exceptions\NamecomException;
use Namecom\Exceptions\NamecomApiException;
use Namecom\Core\Json\JsonApiRequest;
use Namecom\Environments;
use Namecom\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;

class TldPricingClient
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
     * This endpoint returns an alphabetical list of all TLDs supported by name.com, including pricing for each supported order type. All prices are in US Dollars (USD) and apply to non-premium domains. name.com provides three pricing types for each TLD:
     * - Account-Level Pricing - Your price, including any applicable rebates, promotions, or account-level discounts. This is referenced as 'registrationprice', 'renewalprice', 'transferinprice' and 'domainrestorationprice' in this endpoint.
     * - Original Pricing (No Discounts Applied) - The suggested retail price (MSRP) before any discounts are applied.
     * - Retail Pricing (Public Site Pricing) - The current public retail price on name.com, including any public rebates or promotions, but before any account-level discounts.
     *
     * **Important Notes:**
     * - Promo codes are not supported through the API, and therefore are not reflected in any pricing values returned.
     * - General TLD pricing only: This represents standard pricing for domains registered under the specified TLD. Pricing for specific domains may differ based on multiple factors (e.g., premium classifications, registry pricing rules). To retrieve pricing for an individual domain, use the GetPricingForDomain endpoint.
     * - Availability: If a pricing value is returned as null, that product type is not currently supported for the TLD. (Example: registrationPrice = null means registrations are not currently available.)
     * - If you do not have account level pricing, the retail price will always match your account level price. (e.g., registration price = registration retail price)
     *
     * @param TldPriceListRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?TldPriceListResponse
     * @throws NamecomException
     * @throws NamecomApiException
     */
    public function tldPriceList(TldPriceListRequest $request = new TldPriceListRequest(), ?array $options = null): ?TldPriceListResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->perPage != null) {
            $query['perPage'] = $request->perPage;
        }
        if ($request->page != null) {
            $query['page'] = $request->page;
        }
        if ($request->duration != null) {
            $query['duration'] = $request->duration;
        }
        if ($request->tlds != null) {
            $query['tlds'] = $request->tlds;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Sandbox->value,
                    path: "core/v1/tldpricing",
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
                return TldPriceListResponse::fromJson($json);
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
