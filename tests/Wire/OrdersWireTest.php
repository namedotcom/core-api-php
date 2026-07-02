<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\Orders\Requests\ListOrdersRequest;

class OrdersWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListOrders(): void {
        $testId = 'orders.list_orders.0';
        $this->client->orders->listOrders(
            new ListOrdersRequest([]),
            [
                'headers' => [
                    'X-Test-Id' => 'orders.list_orders.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/orders",
            null,
            1
        );
    }

    /**
     */
    public function testGetOrder(): void {
        $testId = 'orders.get_order.0';
        $this->client->orders->getOrder(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'orders.get_order.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/orders/1",
            null,
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
