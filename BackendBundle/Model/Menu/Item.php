<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 21:10
 */

namespace Beaver\BackendBundle\Model\Menu;

class Item
{
	/** @var string $href */
	private $href       = '#';
	
	/** @var string $text */
	private $text       = 'Menu Item';
	
	/** @var array $children */
	private $children   = array();
	
	/**
	 * Item constructor.
	 * @param string $href
	 * @param string $text
	 * @param array $children
	 */
	public function __construct($href = '#', $text = 'Menu Item', $children = array())
	{
		$this->href     = $href;
		$this->text     = $text;
		$this->children = $children;
	}
	
	/**
	 * @return string
	 */
	public function getHref()
	{
		return $this->href;
	}
	
	/**
	 * @param string $href
	 */
	public function setHref($href)
	{
		$this->href = $href;
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
	 * @return array
	 */
	public function getChildren()
	{
		return $this->children;
	}
	
	/**
	 * @param array $children
	 */
	public function setChildren($children)
	{
		$this->children = $children;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function hasChildren()
	{
		return !empty($this->children);
	}
}