<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:44
 */

namespace Beaver\CoreBundle\Model\Configuration;

/**
 * Class BlockTemplate
 * @package Beaver\CoreBundle\Model\Configuration
 */
class BlockTemplate
{
    /** @var integer */
    private $id;
    
    /** @var  string */
    private $name;
    
    /** @var  string */
    private $view;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
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

    public function toArray()
    {
        return [
            'id'    => $this->getId(),
            'name'  => $this->getName(),
            'view'  => $this->getView()
        ];
    }
}
