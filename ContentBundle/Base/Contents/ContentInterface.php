<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/2/17
 * Time: 22:55
 */
namespace Beaver\ContentBundle\Base\Contents;

/**
 * Interface ContentInterface
 * @package Beaver\ContentBundle\Base\Contents
 */
interface ContentInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getListName();
}
