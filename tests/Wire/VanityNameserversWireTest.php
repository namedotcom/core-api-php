<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\VanityNameservers\Requests\ListVanityNameserversRequest;
use Namecom\VanityNameservers\Requests\CreateVanityNameserverBody;
use Namecom\VanityNameservers\Requests\UpdateVanityNameserverBody;

class VanityNameserversWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListVanityNameservers(): void {
        $testId = 'vanity_nameservers.list_vanity_nameservers.0';
        $this->client->vanityNameservers->listVanityNameservers(
            'example.com',
            new ListVanityNameserversRequest([
                'perPage' => 50,
                'page' => 2,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'vanity_nameservers.list_vanity_nameservers.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/example.com/vanity_nameservers",
            ['perPage' => '50', 'page' => '2'],
            1
        );
    }

    /**
     */
    public function testCreateVanityNameserver(): void {
        $testId = 'vanity_nameservers.create_vanity_nameserver.0';
        $this->client->vanityNameservers->createVanityNameserver(
            'example.com',
            new CreateVanityNameserverBody([
                'hostname' => 'ns1',
                'ips' => [
                    '192.168.1.10',
                    '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'vanity_nameservers.create_vanity_nameserver.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com/vanity_nameservers",
            null,
            1
        );
    }

    /**
     */
    public function testGetVanityNameserver(): void {
        $testId = 'vanity_nameservers.get_vanity_nameserver.0';
        $this->client->vanityNameservers->getVanityNameserver(
            'example.com',
            'ns1.example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'vanity_nameservers.get_vanity_nameserver.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/example.com/vanity_nameservers/ns1.example.com",
            null,
            1
        );
    }

    /**
     */
    public function testUpdateVanityNameserver(): void {
        $testId = 'vanity_nameservers.update_vanity_nameserver.0';
        $this->client->vanityNameservers->updateVanityNameserver(
            'example.com',
            'ns1.example.com',
            new UpdateVanityNameserverBody([
                'ips' => [
                    '192.168.1.10',
                    '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'vanity_nameservers.update_vanity_nameserver.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/core/v1/domains/example.com/vanity_nameservers/ns1.example.com",
            null,
            1
        );
    }

    /**
     */
    public function testDeleteVanityNameserver(): void {
        $testId = 'vanity_nameservers.delete_vanity_nameserver.0';
        $this->client->vanityNameservers->deleteVanityNameserver(
            'example.com',
            'ns1.example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'vanity_nameservers.delete_vanity_nameserver.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/core/v1/domains/example.com/vanity_nameservers/ns1.example.com",
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
