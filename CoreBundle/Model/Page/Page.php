<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:44
 */
namespace Beaver\CoreBundle\Model\Page;

use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Model\Interfaces\LayoutInterface;

/**
 * Class Page
 * @package Beaver\CoreBundle\Model
 */
class Page extends Statutory
{
    /** @var  string */
    private $name;
    
    /** @var  string */
    private $slug;
    
    /** @var LayoutInterface */
    private $layout;
    
    /** @var  string */
    private $theme;
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
    
    /**
     * @return LayoutInterface
     */
    public function getLayout()
    {
        return $this->layout;
    }
    
    /**
     * @param Default $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }
	
	/**
	 * @param string $areaName
	 *
	 * @return array
	 * @throws \Exception
	 */
    public function blocksByArea(string $areaName)
    {
    	if (!$this->layout) {
    		throw new \Exception('Layout no definido para esta página!.');
	    }
	    
	    return $this->layout->getArea($areaName)->getBlocks();
    }
    
    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }
    
    /**
     * @param string $theme
     */
    public function setTheme(string $theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'        => $this->getId(),
            'published' => $this->isPublished(),
            'name'      => $this->getName(),
            'slug'      => $this->getSlug(),
            'layout'    => $this->getLayout(),
            'theme'     => $this->getTheme()
        ];
    }
}
