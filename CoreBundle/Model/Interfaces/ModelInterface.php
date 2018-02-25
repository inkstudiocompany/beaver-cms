<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:30
 */

namespace Beaver\CoreBundle\Model\Interfaces;

/**
 * Class ModelInterface
 * @package Beaver\CoreBundle\Model\Interfaces
 */
interface ModelInterface
{
    /**
     * Returns data model represented at array
     */
    public function toArray();
    
    /**
     * Return string data model represented at Json string
     */
    public function toJson();
}
