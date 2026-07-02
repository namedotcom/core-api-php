<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\Accounts\Requests\CreateAccountRequest;
use Namecom\Types\AccountRequest;
use Namecom\Types\ContactsRequest;
use Namecom\Types\RegistrantContactRequest;

class AccountsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testCreateAccount(): void {
        $testId = 'accounts.create_account.0';
        $this->client->accounts->createAccount(
            new CreateAccountRequest([
                'account' => new AccountRequest([
                    'contacts' => new ContactsRequest([
                        'registrant' => new RegistrantContactRequest([
                            'firstName' => 'Jane',
                            'lastName' => 'Doe',
                            'address1' => '123 Main St.',
                            'city' => 'Denver',
                            'state' => 'CO',
                            'zip' => '12345',
                            'country' => 'US',
                            'email' => 'admin@example.net',
                            'phone' => '+13035551212',
                        ]),
                    ]),
                    'accountName' => 'reseller_subaccount',
                    'password' => 'SecureP4ss!',
                ]),
                'apiTos' => true,
                'tos' => true,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'accounts.create_account.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/accounts",
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
