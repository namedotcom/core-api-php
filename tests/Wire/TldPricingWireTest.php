<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\TldPricing\Requests\TldPriceListRequest;

class TldPricingWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testTldPriceList(): void {
        $testId = 'tld_pricing.tld_price_list.0';
        $this->client->tldPricing->tldPriceList(
            new TldPriceListRequest([
                'duration' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'tld_pricing.tld_price_list.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/tldpricing",
            ['duration' => '1'],
            1
        );
    }

    /**
     */
    protected function setUp(): void {
        parent::setUp();
        $wiremockUrl = getenv('WIREMOCK_URL') ?: 'http://localhost:8080';
        $this->client = new NamecomClient(
            username: 'test-username',
                password: 'test-password',
        options: [
            'baseUrl' => $wiremockUrl,
        ],
        );
    }
}
