<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:44
 */
namespace Beaver\CoreBundle\Model\Page;

use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Model\Configuration\Widget as WidgetTemplate;

/**
 * Class Widget
 * @package Beaver\CoreBundle\Model
 */
class Widget extends Statutory
{
    /** @var  integer */
    private $slot;

    /** @var  string */
    private $view;

    /** @var  string */
    private $widget;

    /** @var  array */
    private $data;

    /**
     * @return int
     */
    public function getSlot(): int
    {
        return $this->slot;
    }

    /**
     * @param int $slot
     */
    public function setSlot(int $slot)
    {
        $this->slot = $slot;
        return $this;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView(string $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return string
     */
    public function getWidget(): string
    {
        return $this->widget;
    }

    /**
     * @param string $widget
     */
    public function setWidget(string $widget)
    {
        $this->widget = $widget;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function toArray()
    {
        return [
            'id'            => $this->getId(),
            'view'          => $this->getView(),
            'data'          => $this->getData(),
            'published'     => $this->isPublished(),
        ];
    }
}
