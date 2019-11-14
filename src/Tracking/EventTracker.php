<?php


namespace SymfonyLab\CustomerIOBundle\Tracking;

use Customerio\Api;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use SymfonyLab\CustomerIOBundle\Event\ActionEvent;
use SymfonyLab\CustomerIOBundle\Event\TrackingEvent;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class EventTracker
 * @package Tracking
 */
class EventTracker implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    /**
     * @var Api
     */
    private $api;

    /**
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
        $this->logger = new NullLogger();
    }

    /**
     * @param TrackingEvent $event
     */
    public function onIdentify(TrackingEvent $event)
    {
        $customer = $event->getCustomer();

        $this->logger->info(sprintf('Sending createCustomer request to customer.io with id=%s', $customer->getId()), $customer->getAttributes());

        $response = $this->api->createCustomer(
            $customer->getId(),
            $customer->getEmail(),
            $customer->getAttributes()
        );

        if (!$response->success()) {
            throw new BadRequestHttpException($response->message());
        }
    }

    /**
     * @param ActionEvent $event
     */
    public function onAction(ActionEvent $event)
    {

        $this->logger->info(sprintf('Firing customerio event %s', $event->getAction()), $event->getAttributes());

        $response = $this->api->fireEvent($event->getCustomer()->getId(), $event->getAction(), $event->getAttributes());

        if (!$response->success()) {
            throw new BadRequestHttpException($response->message());
        }
    }

    /**
     * @param Api $api
     */
    public function setApi(Api $api)
    {
        $this->api = $api;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            TrackingEvent::class => 'onIdentify',
            ActionEvent::class => 'onAction',
        );
    }
}