<?php
namespace Beaver\CoreBundle\Entity;

use Doctrine\ORM\Mapping As ORM;

/**
 * Class Widget
 * @package Beaver\CoreBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="beaver_widget")
 */
class Widget
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer", name="block_id")
     */
    private $block;
    
    /**
     * @ORM\Column(type="integer", name="slot")
     */
    private $slot;
    
    /**
     * @ORM\Column(type="string", name="widget")
     */
    private $widget;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * @param mixed $slot
     */
    public function setSlot($slot)
    {
        $this->slot = $slot;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param mixed $widget
     */
    public function setWidget($widget)
    {
        $this->widget = $widget;
        return $this;
    }
}
