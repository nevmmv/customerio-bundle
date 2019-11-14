<?php


namespace SymfonyLab\CustomerIOBundle\Event;

use SymfonyLab\CustomerIOBundle\Model\CustomerInterface;

/**
 * Class ActionEvent
 * @package SymfonyLab\CustomerIOBundle\Event
 */
class ActionEvent extends CustomerEvent
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param CustomerInterface $customer
     * @param null $action
     * @param array $attributes
     */
    public function __construct(CustomerInterface $customer, $action, $attributes = [])
    {
        parent::__construct($customer);

        $this->action = $action;
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}