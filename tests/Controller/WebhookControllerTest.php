<?php



namespace  SymfonyLab\Tests\Controller;

use SymfonyLab\CustomerIOBundle\Event\WebhookEvent;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class WebhookControllerTest
 * @package SymfonyLab\CustomerIOBundle\Tests\Controller
 */
class WebhookControllerTest extends WebTestCase
{
    public function testIndex()
    {

        $client = self::createClient();
        $raw = <<< BODY
    {
      "event_type": "email_delivered",
      "event_id": "5b68360d2bf711479352",
      "timestamp": 1352005930,
      "data": {
        "customer_id": "568",
        "email_address": "customer@example.com",
        "email_id": "34",
        "subject": "Why haven't you visited lately?",
        "campaign_id": "33",
        "campaign_name": "Inactivity Teaser"
      }
    }
BODY;
        $dispatcher = $client->getKernel()->getContainer()->get('event_dispatcher');
        $triggeredHooks = array();

        $dispatcher->addListener(WebhookEvent::EMAIL_DELIVERED, function(WebHookEvent $event) use (&$triggeredHooks) {
            $triggeredHooks[$event->getType()] = true;
        });

        $client->request(
                'POST',
                '/webhook',
                array(),
                array(),
                array('CONTENT_TYPE' => 'application/json'),
                $raw
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey(WebhookEvent::EMAIL_DELIVERED, $triggeredHooks);
        $this->assertTrue($triggeredHooks[WebhookEvent::EMAIL_DELIVERED]);

    }
}
