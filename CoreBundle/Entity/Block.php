<?php
namespace Beaver\CoreBundle\Entity;

use Doctrine\ORM\Mapping As ORM;

/**
 * Class Block
 * @package Beaver\CoreBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="block")
 */
class Block
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="boolean", name="published")
     */
    private $published;
    
    /**
     * @ORM\Column(type="integer", name="page_id")
     */
    private $page;
    
    /**
     * @ORM\Column(type="string", length=50, name="area")
     */
    private $area;
    
    /**
     * @ORM\Column(type="string", name="view")
     */
    private $view;
    
    /**
     * @ORM\Column(type="integer", name="order_block")
     */
    private $order;
    
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
    public function getPublished()
    {
        return $this->published;
    }
    
    /**
     * @param mixed $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }
    
    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }
    
    /**
     * @param mixed $area
     */
    public function setArea($area)
    {
        $this->area = $area;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }
	
	/**
	 * @param $view
	 *
	 * @return $this
	 */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
}
