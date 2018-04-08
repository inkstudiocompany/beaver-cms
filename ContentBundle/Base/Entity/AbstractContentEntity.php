<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/16/17
 * Time: 12:20
 */
namespace Beaver\ContentBundle\Base\Entity;

use Doctrine\ORM\Mapping As ORM;

/**
 * Class AbstractContentEntity
 * @package Beaver\ContentBundle\Base\Entity
 */
abstract class AbstractContentEntity implements ContentEntityInterface
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", name="published")
     */
    protected $published;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
	
	/**
	 * @param mixed $id
	 *
	 * @return $this
	 */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param $published
     * @return $this
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }
	
	/**
	 * @param $property
	 *
	 * @return mixed
	 */
	public function __get($property)
	{
		if (!property_exists($this, $property)){
			throw new \InvalidArgumentException(
				"Getting the field '$property' is not valid for this entity"
			);
		}
		
		$accessor = 'get' . ucfirst(strtolower($property));
		return (method_exists($this, $accessor) && is_callable(array($this, $accessor))) ?
			$this->$accessor() : $this->$property;
	}
	
	/**
	 * String name for content list panel.
	 *
	 * @return string
	 */
	abstract public function getContentName(): string;
}
