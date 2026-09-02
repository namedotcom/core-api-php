<?php

namespace Namecom\Tests;

use Namecom\Tests\Wire\WireMockTestCase;
use Namecom\NamecomClient;
use Namecom\WebhookNotifications\Requests\SubscribeToNotification;
use Namecom\Types\AvailableWebhooks;
use Namecom\WebhookNotifications\Requests\ModifySubscriptionRequest;

class WebhookNotificationsWireTest extends WireMockTestCase
{
    /**
     * @var NamecomClient $client
     */
    private NamecomClient $client;

    /**
     */
    public function testGetSubscribedNotifications(): void {
        $testId = 'webhook_notifications.get_subscribed_notifications.0';
        $this->client->webhookNotifications->getSubscribedNotifications(
            [
                'headers' => [
                    'X-Test-Id' => 'webhook_notifications.get_subscribed_notifications.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/core/v1/notifications",
            null,
            1
        );
    }

    /**
     */
    public function testSubscribeToNotification(): void {
        $testId = 'webhook_notifications.subscribe_to_notification.0';
        $this->client->webhookNotifications->subscribeToNotification(
            new SubscribeToNotification([
                'eventName' => AvailableWebhooks::AccountCreditBalanceChange->value,
                'url' => 'https://example.com',
                'active' => true,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'webhook_notifications.subscribe_to_notification.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/core/v1/notifications",
            null,
            1
        );
    }

    /**
     */
    public function testModifySubscription(): void {
        $testId = 'webhook_notifications.modify_subscription.0';
        $this->client->webhookNotifications->modifySubscription(
            1,
            new ModifySubscriptionRequest([]),
            [
                'headers' => [
                    'X-Test-Id' => 'webhook_notifications.modify_subscription.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/core/v1/notifications/1",
            null,
            1
        );
    }

    /**
     */
    public function testDeleteSubscription(): void {
        $testId = 'webhook_notifications.delete_subscription.0';
        $this->client->webhookNotifications->deleteSubscription(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'webhook_notifications.delete_subscription.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/core/v1/notifications/1",
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
