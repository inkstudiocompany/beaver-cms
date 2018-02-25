<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/3/17
 * Time: 00:25
 */

namespace Beaver\ContentBundle\Base\Entity;

/**
 * Interface ContentEntityInterface
 * @package Beaver\ContentBundle\Base\Entity
 */
interface ContentEntityInterface
{
    /**
     * @return boolean
     */
    public function getPublished();

    /**
     * @param $published
     * @return mixed
     */
    public function setPublished($published);
}