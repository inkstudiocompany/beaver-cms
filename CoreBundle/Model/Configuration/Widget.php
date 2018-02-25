<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:44
 */

namespace Beaver\CoreBundle\Model\Configuration;
use Beaver\CoreBundle\Model\Base\AbstractModel;

/**
 * Class Widget
 * @package Beaver\CoreBundle\Model\Configuration
 */
class Widget extends AbstractModel
{
    /** @var integer */
    private $id;

    /** @var  string */
    private $type;
    
    /** @var  string */
    private $name;

    /** @var  string */
    private $description;
    
    /** @var  string */
    private $view;

    /** @var  string */
    private $contentType;

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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
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
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function toArray()
    {
        return [
            'id'            => $this->getId(),
            'type'          => $this->getType(),
            'name'          => $this->getName(),
            'description'   => $this->getDescription(),
            'view'          => $this->getView(),
            'contentType'   => $this->getContentType()

        ];
    }
}
