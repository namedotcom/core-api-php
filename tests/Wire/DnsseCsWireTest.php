<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\DnsseCs\Requests\CreateDnssecBody;

class DnsseCsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListDnsseCs(): void {
        $testId = 'dnsse_cs.list_dnsse_cs.0';
        $this->client->dnsseCs->listDnsseCs(
            'domainName',
            [
                'headers' => [
                    'X-Test-Id' => 'dnsse_cs.list_dnsse_cs.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName/dnssec",
            null,
            1
        );
    }

    /**
     */
    public function testCreateDnssec(): void {
        $testId = 'dnsse_cs.create_dnssec.0';
        $this->client->dnsseCs->createDnssec(
            'domainName',
            new CreateDnssecBody([]),
            [
                'headers' => [
                    'X-Test-Id' => 'dnsse_cs.create_dnssec.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/domainName/dnssec",
            null,
            1
        );
    }

    /**
     */
    public function testGetDnssec(): void {
        $testId = 'dnsse_cs.get_dnssec.0';
        $this->client->dnsseCs->getDnssec(
            'domainName',
            'digest',
            [
                'headers' => [
                    'X-Test-Id' => 'dnsse_cs.get_dnssec.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName/dnssec/digest",
            null,
            1
        );
    }

    /**
     */
    public function testDeleteDnssec(): void {
        $testId = 'dnsse_cs.delete_dnssec.0';
        $this->client->dnsseCs->deleteDnssec(
            'domainName',
            'digest',
            [
                'headers' => [
                    'X-Test-Id' => 'dnsse_cs.delete_dnssec.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/core/v1/domains/domainName/dnssec/digest",
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
