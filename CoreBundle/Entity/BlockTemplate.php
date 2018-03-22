<?php
namespace Beaver\CoreBundle\Entity;

use Doctrine\ORM\Mapping As ORM;

/**
 * Class BlockTemplate
 * @package Beaver\CoreBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="beaver_app_block_template")
 */
class BlockTemplate
{
    /**
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", name="name")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", name="view")
     */
    private $view;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @param mixed $view
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }
}
