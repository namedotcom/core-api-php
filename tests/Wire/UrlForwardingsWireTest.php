<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\UrlForwardings\Requests\ListUrlForwardingsRequest;
use Namecom\UrlForwardings\Requests\UrlForwardingInput;
use Namecom\UrlForwardings\Types\UrlForwardingInputType;
use Namecom\UrlForwardings\Requests\UpdateUrlForwardingRequest;
use Namecom\Types\UrlForwardingUpdate;
use Namecom\UrlForwardings\Requests\ListUrlForwardingsByDomainRequest;
use Namecom\UrlForwardings\Requests\UpdateUrlForwardingByIdRequest;

class UrlForwardingsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListUrlForwardings(): void {
        $testId = 'url_forwardings.list_url_forwardings.0';
        $this->client->urlForwardings->listUrlForwardings(
            'example.com',
            new ListUrlForwardingsRequest([
                'perPage' => 100,
                'page' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.list_url_forwardings.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/example.com/url/forwarding",
            ['perPage' => '100', 'page' => '1'],
            1
        );
    }

    /**
     */
    public function testCreateUrlForwarding(): void {
        $testId = 'url_forwardings.create_url_forwarding.0';
        $this->client->urlForwardings->createUrlForwarding(
            'example.com',
            new UrlForwardingInput([
                'forwardsTo' => 'https://destination-site.com',
                'host' => 'www',
                'type' => UrlForwardingInputType::Masked->value,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.create_url_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com/url/forwarding",
            null,
            1
        );
    }

    /**
     */
    public function testGetUrlForwarding(): void {
        $testId = 'url_forwardings.get_url_forwarding.0';
        $this->client->urlForwardings->getUrlForwarding(
            'example.com',
            'www.example.org',
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.get_url_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/example.com/url/forwarding/www.example.org",
            null,
            1
        );
    }

    /**
     */
    public function testUpdateUrlForwarding(): void {
        $testId = 'url_forwardings.update_url_forwarding.0';
        $this->client->urlForwardings->updateUrlForwarding(
            'example.com',
            'www.example.org',
            new UpdateUrlForwardingRequest([
                'body' => new UrlForwardingUpdate([]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.update_url_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/core/v1/domains/example.com/url/forwarding/www.example.org",
            null,
            1
        );
    }

    /**
     */
    public function testDeleteUrlForwarding(): void {
        $testId = 'url_forwardings.delete_url_forwarding.0';
        $this->client->urlForwardings->deleteUrlForwarding(
            'example.com',
            'www.example.org',
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.delete_url_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/core/v1/domains/example.com/url/forwarding/www.example.org",
            null,
            1
        );
    }

    /**
     */
    public function testListUrlForwardingsByDomain(): void {
        $testId = 'url_forwardings.list_url_forwardings_by_domain.0';
        $this->client->urlForwardings->listUrlForwardingsByDomain(
            'example.com',
            new ListUrlForwardingsByDomainRequest([
                'perPage' => 100,
                'page' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.list_url_forwardings_by_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/urlforwarding/example.com",
            ['perPage' => '100', 'page' => '1'],
            1
        );
    }

    /**
     */
    public function testGetUrlForwardingById(): void {
        $testId = 'url_forwardings.get_url_forwarding_by_id.0';
        $this->client->urlForwardings->getUrlForwardingById(
            'example.com',
            12345,
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.get_url_forwarding_by_id.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/urlforwarding/example.com/12345",
            null,
            1
        );
    }

    /**
     */
    public function testDeleteUrlForwardingById(): void {
        $testId = 'url_forwardings.delete_url_forwarding_by_id.0';
        $this->client->urlForwardings->deleteUrlForwardingById(
            'example.com',
            12345,
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.delete_url_forwarding_by_id.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/core/v1/urlforwarding/example.com/12345",
            null,
            1
        );
    }

    /**
     */
    public function testUpdateUrlForwardingById(): void {
        $testId = 'url_forwardings.update_url_forwarding_by_id.0';
        $this->client->urlForwardings->updateUrlForwardingById(
            'example.com',
            12345,
            new UpdateUrlForwardingByIdRequest([
                'body' => new UrlForwardingUpdate([]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'url_forwardings.update_url_forwarding_by_id.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/core/v1/urlforwarding/example.com/12345",
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
