<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 21:10
 */

namespace Beaver\BackendBundle\Service;

use Beaver\BackendBundle\Model\Menu\Item;
use Beaver\BackendBundle\Service\Interfaces\WoodMenuAbstract;

/**
 * Class BackendMenuService
 * @package Beaver\BackendBundle\Service
 *
 * Define el menú para backend.
 */
class BackendMenuService extends WoodMenuAbstract
{
	
	/**
	 * getMenu
	 * Retorna un arreglo con los items que componen el menú.
	 *
	 * @return array
	 */
	public function getMenu()
	{
		return new Item('#', 'Beaver CMS', $this->items);
	}
	
	/**
	 * definition
	 * Ejecuta la definición del menú.
	 *
	 * @return void
	 */
	protected function definition()
	{
		$this
			->addItem(new Item('#', 'Mi primer menú'))
			->addItem(new Item($this->router->generate('beaver.backend.default'), 'Mi primer sub-menú'))
		;
	}
}