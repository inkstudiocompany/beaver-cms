<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/3/17
 * Time: 00:28
 */
namespace Beaver\ContentBundle\Contents\Banner;

use Beaver\ContentBundle\Base\Contents\AbstractContent;

/**
 * Class Banner
 * @package Beaver\ContentBundle\Banner
 */
class Banner extends AbstractContent
{
    const TYPE = 'BANNER';

    /**
     * @var string
     */
    private $name;

    /**
     * @var text
     */
    private $text;

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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getListName()
    {
        return $this->getName();
    }

    /**
     * Returns data model represented at array
     */
    public function toArray()
    {
        return [
            'id'        => $this->getId(),
            'name'      => $this->getName(),
            'text'      => $this->getText(),
            'published' => $this->isPublished()
        ];
    }
}
