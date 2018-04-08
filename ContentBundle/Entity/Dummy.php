<?php
namespace Beaver\ContentBundle\Entity;

use Beaver\ContentBundle\Base\Entity\AbstractContentEntity;
use Doctrine\ORM\Mapping As ORM;

/**
 * Class Dummy
 * @package Beaver\ContentBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="demo_content_dummy")
 */
class Dummy extends AbstractContentEntity
{
    /**
     * @ORM\Column(type="string", name="attribute")
     */
    private $attribute;
	
	/**
	 * @ORM\Column(type="string", name="image")
	 */
	private $image;

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
	
	/**
	 * @param mixed $attribute
	 *
	 * @return \Beaver\ContentBundle\Entity\Dummy
	 */
    public function setAttribute($attribute): self
    {
        $this->attribute = $attribute;
        return $this;
    }
	
	/**
	 * @return mixed
	 */
	public function getImage()
	{
		return $this->image;
	}
	
	/**
	 * @param mixed $image
	 *
	 * @return \Beaver\ContentBundle\Entity\Dummy
	 */
	public function setImage($image): self
	{
		$this->image = $image;
		return $this;
	}
	
	/**
	 * String name for content list panel.
	 *
	 * @return string
	 */
	public function getContentName(): string
	{
		return $this->getAttribute();
	}
}
