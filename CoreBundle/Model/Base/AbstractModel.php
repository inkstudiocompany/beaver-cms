<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:42
 */
namespace Beaver\CoreBundle\Model\Base;

use Beaver\CoreBundle\Model\Interfaces\ModelInterface;

/**
 * Class ModelBase
 * @package Beaver\CoreBundle\Model\Base
 */
abstract class AbstractModel implements ModelInterface
{
    /**
     * Returns data model represented at array
     */
    abstract public function toArray();
    
    /**
     * Return string data model represented at Json string
     */
    public function toJson()
    {
        return json_encode($this->toArray(), JSON_FORCE_OBJECT);
    }
}
