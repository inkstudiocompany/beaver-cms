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
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }
}
