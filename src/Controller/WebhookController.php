<?php


namespace SymfonyLab\CustomerIOBundle\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use SymfonyLab\CustomerIOBundle\Event\WebhookEvent;

/**
 * Class WebhookController
 * @package SymfonyLab\CustomerIOBundle\Controller
 */
class WebhookController extends AbstractController
{
    /**
     * @param Request $request
     * @param LoggerInterface $logger
     * @return Response
     */
    public function postAction(Request $request, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher)
    {
        $eventData = $request->request->all();
        $type = WebhookEvent::getName($eventData['event_type']);

        $logger->info('Dispatching ' . $type . ' event');
        $eventDispatcher->dispatch(new WebHookEvent($type, $eventData));

        return new Response();
    }
}
