<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/2/17
 * Time: 22:58
 */
namespace Beaver\ContentBundle\Base\Contents;

use Beaver\CoreBundle\Model\Base\Statutory;

/**
 * Class AbstractContent
 * @package Beaver\ContentBundle\Base
 */
abstract class AbstractContent extends Statutory implements ContentInterface
{
    /** @var  int */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
	
	/**
	 * @param int $id
	 *
	 * @return $this
	 */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    abstract public function getListName();
}
