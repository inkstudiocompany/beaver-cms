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
 * Class Content
 *
 * @package Beaver\ContentBundle\Base\Contents
 */
abstract class Content extends Statutory
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
	 * Returns data model represented at array
	 */
	public function toArray()
	{
		// TODO: Implement toArray() method.
	}
}
