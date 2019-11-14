<?php


namespace SymfonyLab\CustomerIOBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class WebhookEvent
 * @package SymfonyLab\CustomerIOBundle\Event
 * @see http://customer.io/docs/webhooks.html
 */
class WebhookEvent extends Event
{
    const EMAIL_DRAFTED = "customer_io.email_drafted";
    const EMAIL_SENT = "customer_io.email_sent";
    const EMAIL_DELIVERED = "customer_io.email_delivered";
    const EMAIL_OPENED = "customer_io.email_opened";
    const EMAIL_CLICKED = "customer_io.email_clicked";
    const EMAIL_BOUNCED = "customer_io.email_bounced";
    const EMAIL_SPAMMED = "customer_io.email_spammed";
    const EMAIL_DROPPED = "customer_io.email_dropped";
    const EMAIL_FAILED = "customer_io.email_failed";
    const CUSTOMER_UNSUBSCRIBED = "customer_io.customer_unsubscribed";
    const CUSTOMER_SUBSCRIBED = "customer_io.customer_subscribed";

    public static function getName($type)
    {
        return sprintf('customer_io.%s', $type);
    }

    /**
     * @var array
     */
    private $data;

    /**
     * @var
     */
    private $type;

    /**
     * @param $type
     * @param array $data
     */
    public function __construct($type, array $data)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->data['data']['email_address'];
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->data['data']['customer_id'];
    }
}
