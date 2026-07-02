<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\Domains\Requests\ListDomainsRequest;
use Namecom\Domains\Requests\CreateDomainRequest;
use Namecom\Types\DomainCreatePayload;
use Namecom\Domains\Requests\UpdateDomainRequest;
use Namecom\Domains\Types\UpdateDomainRequestBodyAutorenewEnabled;
use Namecom\Domains\Requests\GetPricingForDomainRequest;
use Namecom\Domains\Requests\DomainsPurchasePrivacyBody;
use Namecom\Domains\Requests\DomainsRenewDomainBody;
use Namecom\Domains\Requests\DomainsSetContactsBody;
use Namecom\Domains\Requests\DomainsSetNameserversBody;
use Namecom\Domains\Requests\AvailabilityRequest;
use Namecom\Domains\Requests\SearchRequest;
use Namecom\Domains\Requests\ZoneCheckRequest;

class DomainsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListDomains(): void {
        $testId = 'domains.list_domains.0';
        $this->client->domains->listDomains(
            new ListDomainsRequest([]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.list_domains.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains",
            null,
            1
        );
    }

    /**
     */
    public function testCreateDomain(): void {
        $testId = 'domains.create_domain.0';
        $this->client->domains->createDomain(
            new CreateDomainRequest([
                'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
                'domain' => new DomainCreatePayload([
                    'domainName' => 'example.com',
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.create_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains",
            null,
            1
        );
    }

    /**
     */
    public function testGetDomain(): void {
        $testId = 'domains.get_domain.0';
        $this->client->domains->getDomain(
            'example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.get_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/example.com",
            null,
            1
        );
    }

    /**
     */
    public function testUpdateDomain(): void {
        $testId = 'domains.update_domain.0';
        $this->client->domains->updateDomain(
            'domainName',
            new UpdateDomainRequest([
                'body' => new UpdateDomainRequestBodyAutorenewEnabled([
                    'autorenewEnabled' => true,
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.update_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/core/v1/domains/domainName",
            null,
            1
        );
    }

    /**
     */
    public function testDisableAutorenew(): void {
        $testId = 'domains.disable_autorenew.0';
        $this->client->domains->disableAutorenew(
            'example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.disable_autorenew.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com:disableAutorenew",
            null,
            1
        );
    }

    /**
     */
    public function testDisableWhoisPrivacy(): void {
        $testId = 'domains.disable_whois_privacy.0';
        $this->client->domains->disableWhoisPrivacy(
            'example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.disable_whois_privacy.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com:disableWhoisPrivacy",
            null,
            1
        );
    }

    /**
     */
    public function testEnableAutorenew(): void {
        $testId = 'domains.enable_autorenew.0';
        $this->client->domains->enableAutorenew(
            'example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.enable_autorenew.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com:enableAutorenew",
            null,
            1
        );
    }

    /**
     */
    public function testEnableWhoisPrivacy(): void {
        $testId = 'domains.enable_whois_privacy.0';
        $this->client->domains->enableWhoisPrivacy(
            'domainName',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.enable_whois_privacy.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/domainName:enableWhoisPrivacy",
            null,
            1
        );
    }

    /**
     */
    public function testGetAuthCodeForDomain(): void {
        $testId = 'domains.get_auth_code_for_domain.0';
        $this->client->domains->getAuthCodeForDomain(
            'domainName',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.get_auth_code_for_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName:getAuthCode",
            null,
            1
        );
    }

    /**
     */
    public function testGetPricingForDomain(): void {
        $testId = 'domains.get_pricing_for_domain.0';
        $this->client->domains->getPricingForDomain(
            'domainName',
            new GetPricingForDomainRequest([
                'years' => 2,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.get_pricing_for_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName:getPricing",
            ['years' => '2'],
            1
        );
    }

    /**
     */
    public function testLockDomain(): void {
        $testId = 'domains.lock_domain.0';
        $this->client->domains->lockDomain(
            'example.com',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.lock_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com:lock",
            null,
            1
        );
    }

    /**
     */
    public function testPurchasePrivacy(): void {
        $testId = 'domains.purchase_privacy.0';
        $this->client->domains->purchasePrivacy(
            'domainName',
            new DomainsPurchasePrivacyBody([
                'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.purchase_privacy.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/domainName:purchasePrivacy",
            null,
            1
        );
    }

    /**
     */
    public function testRenewDomain(): void {
        $testId = 'domains.renew_domain.0';
        $this->client->domains->renewDomain(
            'domainName',
            new DomainsRenewDomainBody([]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.renew_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/domainName:renew",
            null,
            1
        );
    }

    /**
     */
    public function testSetContacts(): void {
        $testId = 'domains.set_contacts.0';
        $this->client->domains->setContacts(
            'example.com',
            new DomainsSetContactsBody([]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.set_contacts.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com:setContacts",
            null,
            1
        );
    }

    /**
     */
    public function testSetNameservers(): void {
        $testId = 'domains.set_nameservers.0';
        $this->client->domains->setNameservers(
            'example.com',
            new DomainsSetNameserversBody([
                'nameservers' => [
                    'ns1.name.com',
                    'ns2.name.com',
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.set_nameservers.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com:setNameservers",
            null,
            1
        );
    }

    /**
     */
    public function testUnlockDomain(): void {
        $testId = 'domains.unlock_domain.0';
        $this->client->domains->unlockDomain(
            'domainName',
            [
                'headers' => [
                    'X-Test-Id' => 'domains.unlock_domain.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/domainName:unlock",
            null,
            1
        );
    }

    /**
     */
    public function testCheckAvailability(): void {
        $testId = 'domains.check_availability.0';
        $this->client->domains->checkAvailability(
            new AvailabilityRequest([
                'domainNames' => [
                    'domainNames',
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.check_availability.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains:checkAvailability",
            null,
            1
        );
    }

    /**
     */
    public function testSearch(): void {
        $testId = 'domains.search.0';
        $this->client->domains->search(
            new SearchRequest([
                'keyword' => 'mydomain',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.search.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains:search",
            null,
            1
        );
    }

    /**
     */
    public function testZoneCheck(): void {
        $testId = 'domains.zone_check.0';
        $this->client->domains->zoneCheck(
            new ZoneCheckRequest([
                'domainNames' => [
                    'example.com',
                    'example.net',
                    'example.org',
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'domains.zone_check.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/zonecheck",
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
