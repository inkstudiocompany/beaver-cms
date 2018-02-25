<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:44
 */
namespace Beaver\CoreBundle\Model\Page;

use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Model\Configuration\BlockTemplate;

/**
 * Class Block
 * @package Beaver\CoreBundle\Model
 */
class Block extends Statutory
{
    /** @var integer */
    private $page;
    
    /** @var  string */
    private $area;
    
    /** @var string */
    private $view;

    /** @var  array */
    private $widgets = array();
    
    /** @var integer */
    private $order;
    
    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
    
    /**
     * @param int $page
     */
    public function setPage(int $page)
    {
        $this->page = $page;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }
    
    /**
     * @param string $area
     */
    public function setArea($area)
    {
        $this->area = $area;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }
    
    /**
     * @param int $order
     */
    public function setOrder(int $order)
    {
        $this->order = $order;
        return $this;
    }
    
    /**
     * @return BlockTemplate
     */
    public function getView()
    {
        return $this->view;
    }
    
    /**
     * @param string $view
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return string|bool
     */
    public function getLayout()
    {
        return  $this->view;
    }

    /**
     * @param Widget    $widget
     * @return $this
     */
    public function addWidget(Widget $widget)
    {
        if (false === isset($this->widgets[$widget->getSlot()])) {
            $this->widgets[$widget->getSlot()] = array();
        }
        $this->widgets[$widget->getSlot()][] = $widget;
        return $this;
    }

    public function getWidgets()
    {
        return $this->widgets;
    }

    public function getSlot($slot)
    {
        if (false === isset($this->widgets[$slot])) {
            return false;
        }
        return $this->widgets[$slot];
    }
	
	/**
	 * @return array
	 */
    public function toArray()
    {
        return [
            'id'            => $this->getId(),
            'published'     => $this->isPublished(),
            'page'          => $this->getPage(),
            'area'          => $this->getArea(),
            'view'          => $this->getView(),
            'order'         => $this->getOrder()
        ];
    }
}
