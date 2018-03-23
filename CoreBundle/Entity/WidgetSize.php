<?php
namespace Beaver\CoreBundle\Entity;

use Doctrine\ORM\Mapping As ORM;

/**
 * Class Block
 * @package Beaver\CoreBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="beaver_widget_size")
 */
class WidgetSize
{
    /**
     * @ORM\Column(type="integer", name="widget_id")
     * @ORM\Id
     */
    private $widget;

    /**
     * @ORM\Column(type="integer", name="size")
     * @ORM\Id
     */
    private $size;

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

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
}
