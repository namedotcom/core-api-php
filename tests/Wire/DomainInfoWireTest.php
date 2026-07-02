<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\DomainInfo\Requests\DomainClaimsCheckRequest;

class DomainInfoWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testGetRequirement(): void {
        $testId = 'domain_info.get_requirement.0';
        $this->client->domainInfo->getRequirement(
            'fr',
            [
                'headers' => [
                    'X-Test-Id' => 'domain_info.get_requirement.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domaininfo/requirements/fr",
            null,
            1
        );
    }

    /**
     */
    public function testCheckDomainClaims(): void {
        $testId = 'domain_info.check_domain_claims.0';
        $this->client->domainInfo->checkDomainClaims(
            'tiktok.page',
            new DomainClaimsCheckRequest([]),
            [
                'headers' => [
                    'X-Test-Id' => 'domain_info.check_domain_claims.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domaininfo/claims/tiktok.page",
            null,
            1
        );
    }

    /**
     */
    public function testGetTldRequirementsV2(): void {
        $testId = 'domain_info.get_tld_requirements_v2.0';
        $this->client->domainInfo->getTldRequirementsV2(
            'fr',
            [
                'headers' => [
                    'X-Test-Id' => 'domain_info.get_tld_requirements_v2.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domaininfo/requirementsV2/fr",
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
