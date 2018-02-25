<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 21:10
 */
namespace Beaver\BackendBundle\Service;

use Beaver\BackendBundle\Model\Menu\Item;
use Beaver\CoreBundle\Service\ContentService;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class MenuBuilderService
 * @package Beaver\BackendBundle\Service
 */
class MenuBuilderService
{
	/** @var array $items */
	private $items      = [];
	
	/** @var Router $router */
	private $router     = null;

	/** @var  ContentService */
	private $contentService;
	
	/**
	 * MenuBuilderService constructor.
	 */
	public function __construct(Router $router, $contextService)
	{
		$this->router           = $router;
		$this->contentService   = $contextService;
		$this->items['woods']   = [];
		$this->items['beaver']  = [];
		$this->define();
	}
	
	/**
	 * addItem
	 * @param Item      $item
	 * @param string    $menu
	 *
	 * Agrega un item al menú de módulos.
	 */
	public function addItem ($item, $menu = 'woods')
	{
		$this->items[$menu][] = $item;
		return $this;
	}
	
	/**
	 * @param $woodMenuService
	 */
	public function addWoodMenuService ($woodMenuService)
	{
		$this->addItem($woodMenuService->getMenu());
	}
		
	
	/**
	 * @return array
	 */
	public function getMenu()
	{
		return $this->items;
	}
	
	/**
	 * define
	 *
	 * Define el menú de configuraciones del CMS.
	 */
	public function define()
	{
		$this
			->addItem(new Item($this->router->generate('beaver.backend.default'), 'Dashboard'), 'beaver')
			->addItem(new Item('#', 'Configuración'), 'beaver')
			->addItem(
			    new Item(
			        $this->router->generate('beaver.backend.pages'),
                    'Páginas', [
                        new Item($this->router->generate('beaver.backend.page.new'), 'Nueva página')
                    ]
                )
            , 'woods')
            ->addItem(
                new Item(
                    $this->router->generate('beaver.backend.dashboard'),
                    'Contenidos', $this->contents()

                )
            )
		;
	}

	private function contents()
    {
        $typeContents = [];
        foreach ($this->contentService->getContents() as $type => $content) {
            $typeContents[] = new Item($this->router->generate('beaver.backend.contents', ['content' => strtolower($type)]), $type);
        }
        return $typeContents;
    }
}