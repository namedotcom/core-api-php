<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\Transfers\Requests\ListTransfersRequest;
use Namecom\Transfers\Requests\CreateTransferRequest;
use Namecom\Transfers\Requests\CreateInternalTransferInRequest;

class TransfersWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListTransfers(): void {
        $testId = 'transfers.list_transfers.0';
        $this->client->transfers->listTransfers(
            new ListTransfersRequest([]),
            [
                'headers' => [
                    'X-Test-Id' => 'transfers.list_transfers.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/transfers",
            null,
            1
        );
    }

    /**
     */
    public function testCreateTransfer(): void {
        $testId = 'transfers.create_transfer.0';
        $this->client->transfers->createTransfer(
            new CreateTransferRequest([
                'authCode' => 'ABC123',
                'domainName' => 'example.com',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'transfers.create_transfer.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/transfers",
            null,
            1
        );
    }

    /**
     */
    public function testGetTransfer(): void {
        $testId = 'transfers.get_transfer.0';
        $this->client->transfers->getTransfer(
            'domainName',
            [
                'headers' => [
                    'X-Test-Id' => 'transfers.get_transfer.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/transfers/domainName",
            null,
            1
        );
    }

    /**
     */
    public function testCancelTransfer(): void {
        $testId = 'transfers.cancel_transfer.0';
        $this->client->transfers->cancelTransfer(
            'domainName',
            [
                'headers' => [
                    'X-Test-Id' => 'transfers.cancel_transfer.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/transfers/domainName:cancel",
            null,
            1
        );
    }

    /**
     */
    public function testCancelOutboundTransfer(): void {
        $testId = 'transfers.cancel_outbound_transfer.0';
        $this->client->transfers->cancelOutboundTransfer(
            'example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'transfers.cancel_outbound_transfer.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/transfers/external/out/example.com:cancel",
            null,
            1
        );
    }

    /**
     */
    public function testCreateInternalTransferIn(): void {
        $testId = 'transfers.create_internal_transfer_in.0';
        $this->client->transfers->createInternalTransferIn(
            new CreateInternalTransferInRequest([
                'domainName' => 'example.com',
                'authCode' => 'ABC123',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'transfers.create_internal_transfer_in.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/transfers/internal/in",
            null,
            1
        );
    }

    /**
     */
    public function testGetTransferEligibility(): void {
        $testId = 'transfers.get_transfer_eligibility.0';
        $this->client->transfers->getTransferEligibility(
            'domainName',
            [
                'headers' => [
                    'X-Test-Id' => 'transfers.get_transfer_eligibility.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/transfers/eligibility/domainName",
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
