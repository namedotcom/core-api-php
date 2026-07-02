<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\Dns\Requests\ListRecordsRequest;
use Namecom\Dns\Requests\DnsCreateRecordBody;
use Namecom\Dns\Types\DnsCreateRecordBodyType;
use Namecom\Dns\Requests\DnsUpdateRecordBody;
use Namecom\Dns\Types\DnsUpdateRecordBodyType;

class DnsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListRecords(): void {
        $testId = 'dns.list_records.0';
        $this->client->dns->listRecords(
            'domainName',
            new ListRecordsRequest([]),
            [
                'headers' => [
                    'X-Test-Id' => 'dns.list_records.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName/records",
            null,
            1
        );
    }

    /**
     */
    public function testCreateRecord(): void {
        $testId = 'dns.create_record.0';
        $this->client->dns->createRecord(
            'domainName',
            new DnsCreateRecordBody([
                'answer' => 'answer',
                'host' => 'host',
                'type' => DnsCreateRecordBodyType::A->value,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'dns.create_record.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/domainName/records",
            null,
            1
        );
    }

    /**
     */
    public function testGetRecord(): void {
        $testId = 'dns.get_record.0';
        $this->client->dns->getRecord(
            'domainName',
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'dns.get_record.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName/records/1",
            null,
            1
        );
    }

    /**
     */
    public function testUpdateRecord(): void {
        $testId = 'dns.update_record.0';
        $this->client->dns->updateRecord(
            'domainName',
            1,
            new DnsUpdateRecordBody([
                'answer' => 'answer',
                'type' => DnsUpdateRecordBodyType::A->value,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'dns.update_record.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/core/v1/domains/domainName/records/1",
            null,
            1
        );
    }

    /**
     */
    public function testDeleteRecord(): void {
        $testId = 'dns.delete_record.0';
        $this->client->dns->deleteRecord(
            'domainName',
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'dns.delete_record.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/core/v1/domains/domainName/records/1",
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
