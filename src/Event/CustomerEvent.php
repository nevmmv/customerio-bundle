<?php


namespace SymfonyLab\CustomerIOBundle\Event;

use SymfonyLab\CustomerIOBundle\Model\CustomerInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class CustomerEvent
 * @package SymfonyLab\CustomerIOBundle\Event
 */
class CustomerEvent extends Event
{
    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @param CustomerInterface $customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}