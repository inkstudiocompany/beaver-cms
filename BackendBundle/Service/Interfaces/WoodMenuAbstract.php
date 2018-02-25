<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 21:10
 */

namespace Beaver\BackendBundle\Service\Interfaces;

use Beaver\BackendBundle\Model\Menu\Item;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class WoodMenuAbstract
 * @package Beaver\BackendBundle\Service\Interfaces
 */
abstract class  WoodMenuAbstract
{
	/** @var array $items */
	protected $items = [];
	
	/** @var Router $router */
	protected $router   = null;
	
	/**
	 * WoodMenuAbstract constructor.
	 */
	public function __construct(Router $router)
	{
		$this->router = $router;
		$this->definition();
	}
	
	/**
	 * getMenu
	 * Retorna un arreglo con los items que componen el menú.
	 *
	 * @return array
	 */
	abstract public function getMenu();
	
	/**
	 * definition
	 * Ejecuta la definición del menú.
	 *
	 * @return void
	 */
	abstract protected function definition();
	
	/**
	 * addItem
	 * Agrega un item a la lista.
	 *
	 * @param Item $item
	 */
	protected function addItem(Item $item)
	{
		$this->items[] = $item;
		return $this;
	}
}