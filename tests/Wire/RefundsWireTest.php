<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\Refunds\Requests\RefundRequest;

class RefundsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testProcessRefund(): void {
        $testId = 'refunds.process_refund.0';
        $this->client->refunds->processRefund(
            new RefundRequest([
                'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
                'orderId' => 123456,
                'orderItemIds' => [
                    987654,
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'refunds.process_refund.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/refund",
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
