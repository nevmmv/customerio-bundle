<?php


namespace SymfonyLab\Tests\Tracker;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SymfonyLab\CustomerIOBundle\Event\ActionEvent;
use SymfonyLab\CustomerIOBundle\Event\TrackingEvent;
use SymfonyLab\CustomerIOBundle\Tracking\EventTracker;

/***
 * Class EventTrackerTest
 * @package Tests\Tracker
 */
class EventTrackerTest extends WebTestCase
{
    public function testCustomerCreation()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $api = $this->getMockBuilder('\Customerio\Api')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\Customerio\Response')->disableOriginalConstructor()->getMock();

        $response->expects($this->once())->method('success')->willReturn(true);
        $api->expects($this->once())->method('createCustomer')->willReturn($response);

        static::$kernel->getContainer()->get('symfonylab_customer_io.api', $api);

        /** @var EventTracker $tracker */
        $tracker = static::$kernel->getContainer()->get('symfonylab_customer_io.tracker');

        $tracker->setApi($api);

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = static::$kernel->getContainer()->get('event_dispatcher');

        $customer = new TestCustomer('foo', 'test@example.com', array('foo' => 'bar'));
        $dispatcher->dispatch(new TrackingEvent($customer));
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testCustomerCreationException()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $api = $this->getMockBuilder('\Customerio\Api')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\Customerio\Response')->disableOriginalConstructor()->getMock();

        $response->expects($this->once())->method('success')->willReturn(false);
        $api->expects($this->once())->method('createCustomer')->willReturn($response);

        static::$kernel->getContainer()->get('symfonylab_customer_io.api', $api);

        /** @var EventTracker $tracker */
        $tracker = static::$kernel->getContainer()->get('symfonylab_customer_io.tracker');

        $tracker->setApi($api);

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = static::$kernel->getContainer()->get('event_dispatcher');

        $customer = new TestCustomer('foo', 'test@example.com', array('foo' => 'bar'));
        $dispatcher->dispatch(new TrackingEvent($customer));
    }

    public function testEventTracking()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $api = $this->getMockBuilder('\Customerio\Api')->disableOriginalConstructor()->getMock();

        $response = $this->getMockBuilder('\Customerio\Response')->disableOriginalConstructor()->getMock();

        $response->expects($this->once())->method('success')->willReturn(true);
        $api->expects($this->once())->method('fireEvent')->willReturn($response);

        static::$kernel->getContainer()->get('symfonylab_customer_io.api', $api);

        /** @var EventTracker $tracker */
        $tracker = static::$kernel->getContainer()->get('symfonylab_customer_io.tracker');

        $tracker->setApi($api);

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = static::$kernel->getContainer()->get('event_dispatcher');

        $customer = new TestCustomer('foo', 'test@example.com', array('foo' => 'bar'));
        $dispatcher->dispatch(new ActionEvent($customer, 'click'));
    }

}