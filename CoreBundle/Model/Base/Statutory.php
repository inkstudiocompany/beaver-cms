<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:45
 */
namespace Beaver\CoreBundle\Model\Base;

/**
 * Class AbstractComponent
 * @package Beaver\CoreBundle\Model\Page
 */
abstract class Statutory extends AbstractModel
{
    const PUBLISHED     = true;
    const UNPUBLISHED   = false;
    
    /** @var integer */
    protected $id;
    
    /** @var boolean */
    protected $published;
    
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
	 * @return \Beaver\CoreBundle\Model\Base\Statutory
	 */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }
	
	/**
	 * @param bool $published
	 *
	 * @return \Beaver\CoreBundle\Model\Base\Statutory
	 */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }
}
