<?php



namespace SymfonyLab\CustomerIOBundle\Model;

/**
 * Interface CustomerInterface
 * @package SymfonyLab\CustomerIOBundle\Model
 */
interface CustomerInterface
{

    /**
     * @return string
     */
    function getId();

    /**
     * @return string
     */
    function getEmail();

    /**
     * @return array
     */
    function getAttributes();

}