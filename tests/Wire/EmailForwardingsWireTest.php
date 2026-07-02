<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\EmailForwardings\Requests\ListEmailForwardingsRequest;
use Namecom\EmailForwardings\Requests\CreateEmailForwardingRequest;
use Namecom\EmailForwardings\Requests\EmailForwardingsUpdateEmailForwardingBody;

class EmailForwardingsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testListEmailForwardings(): void {
        $testId = 'email_forwardings.list_email_forwardings.0';
        $this->client->emailForwardings->listEmailForwardings(
            'domainName',
            new ListEmailForwardingsRequest([
                'perPage' => 100,
                'page' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'email_forwardings.list_email_forwardings.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName/email/forwarding",
            ['perPage' => '100', 'page' => '1'],
            1
        );
    }

    /**
     */
    public function testCreateEmailForwarding(): void {
        $testId = 'email_forwardings.create_email_forwarding.0';
        $this->client->emailForwardings->createEmailForwarding(
            'example.com',
            new CreateEmailForwardingRequest([
                'emailBox' => 'admin',
                'emailTo' => 'webmaster@example.com',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'email_forwardings.create_email_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/domains/example.com/email/forwarding",
            null,
            1
        );
    }

    /**
     */
    public function testGetEmailForwarding(): void {
        $testId = 'email_forwardings.get_email_forwarding.0';
        $this->client->emailForwardings->getEmailForwarding(
            'domainName',
            'emailBox',
            [
                'headers' => [
                    'X-Test-Id' => 'email_forwardings.get_email_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/domains/domainName/email/forwarding/emailBox",
            null,
            1
        );
    }

    /**
     */
    public function testUpdateEmailForwarding(): void {
        $testId = 'email_forwardings.update_email_forwarding.0';
        $this->client->emailForwardings->updateEmailForwarding(
            'domainName',
            'emailBox',
            new EmailForwardingsUpdateEmailForwardingBody([]),
            [
                'headers' => [
                    'X-Test-Id' => 'email_forwardings.update_email_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/core/v1/domains/domainName/email/forwarding/emailBox",
            null,
            1
        );
    }

    /**
     */
    public function testDeleteEmailForwarding(): void {
        $testId = 'email_forwardings.delete_email_forwarding.0';
        $this->client->emailForwardings->deleteEmailForwarding(
            'domainName',
            'emailBox',
            [
                'headers' => [
                    'X-Test-Id' => 'email_forwardings.delete_email_forwarding.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/core/v1/domains/domainName/email/forwarding/emailBox",
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
