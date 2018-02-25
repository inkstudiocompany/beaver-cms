<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/3/17
 * Time: 00:28
 */
namespace Beaver\ContentBundle\Contents\Dummy;

use Beaver\ContentBundle\Base\Contents\AbstractContent;

/**
 * Class Banner
 * @package Beaver\ContentBundle\Banner
 */
class Dummy extends AbstractContent
{
    const TYPE = 'DUMMY';

    /**
     * @var string
     */
    private $dummyAttribute;

    /**
     * @return string
     */
    public function getDummyAttribute(): string
    {
        return $this->dummyAttribute;
    }

    /**
     * @param string $dummyAttribute
     */
    public function setDummyAttribute(string $dummyAttribute)
    {
        $this->dummyAttribute = $dummyAttribute;
        return $this;
    }

    /**
     * Returns data model represented at array
     */
    public function toArray()
    {
        return [
            'id'        => $this->getId(),
            'attribute' => $this->getDummyAttribute(),
            'published' => $this->isPublished()
        ];
    }

    /**
     * @return string
     */
    public function getListName()
    {
        return 'dummy attribute';
    }
}
