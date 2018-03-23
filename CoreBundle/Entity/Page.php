<?php
namespace Beaver\CoreBundle\Entity;

use Doctrine\ORM\Mapping As ORM;

/**
 * Class Page
 * @package Beaver\CoreBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="beaver_page")
 */
class Page
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
     * @ORM\Column(type="string", length=50, name="name")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=50, name="slug")
     */
    private $slug;
    
    /**
     * @ORM\Column(type="string", length=50, name="layout")
     */
    private $layout;
    
    /**
     * @ORM\Column(type="string", length=50, name="theme")
     */
    private $theme;
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
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
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }
    
    /**
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
    
    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }
    
    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }
}
