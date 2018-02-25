<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/3/17
 * Time: 15:50
 */
namespace Beaver\CoreBundle\Model\Page;

/**
 * Class Area
 * @package Beaver\CoreBundle\Model\Page
 */
class Area
{
    /** @var string */
    private $name;
    
    /** @var array */
    private $blocks;
    
    /**
     * Area constructor.
     * @param string $name
     * @param array $blocks
     */
    public function __construct($name, array $blocks)
    {
        $this->name = $name;
        $this->blocks = $blocks;
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
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
    
    /**
     * @param array $blocks
     */
    public function setBlocks(array $blocks)
    {
        $this->blocks = $blocks;
        return $this;
    }
    
    /**
     * @param Block $block
     */
    public function addBlock(Block $block)
    {
        array_push($this->blocks, $block);
        return $this;
    }
}
