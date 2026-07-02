<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\ContactVerification\Requests\UnverifiedContactsListRequest;
use Namecom\ContactVerification\Requests\VerifyContactRequest;
use Namecom\ContactVerification\Requests\ResendContactVerificationEmailRequest;

class ContactVerificationWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testUnverifiedContactsList(): void {
        $testId = 'contact_verification.unverified_contacts_list.0';
        $this->client->contactVerification->unverifiedContactsList(
            new UnverifiedContactsListRequest([
                'perPage' => 100,
                'page' => 2,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'contact_verification.unverified_contacts_list.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/contacts/unverified",
            ['perPage' => '100', 'page' => '2'],
            1
        );
    }

    /**
     */
    public function testVerifyContact(): void {
        $testId = 'contact_verification.verify_contact.0';
        $this->client->contactVerification->verifyContact(
            1,
            new VerifyContactRequest([
                'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'contact_verification.verify_contact.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/contacts/verify/1",
            null,
            1
        );
    }

    /**
     */
    public function testResendContactVerificationEmail(): void {
        $testId = 'contact_verification.resend_contact_verification_email.0';
        $this->client->contactVerification->resendContactVerificationEmail(
            1,
            new ResendContactVerificationEmailRequest([
                'idempotencyKey' => '083910ef-04e4-4bd1-a0bf-3737fe005ca8',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'contact_verification.resend_contact_verification_email.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/contacts/verify/1:resend",
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
