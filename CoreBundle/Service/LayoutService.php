<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 19:56
 */

namespace Beaver\CoreBundle\Service;

use Beaver\CoreBundle\Model\Interfaces\LayoutInterface;
use Beaver\CoreBundle\Model\Page\Layout\DefaultLayout;
use Beaver\CoreBundle\Response\MixedResponse;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class LayoutService
 * @package Beaver\CoreBundle\Service
 *
 * Servicio para el manejo de layout
 */
class LayoutService
{
    /** @var array */
    private $layouts = array();

    /** @var  Container */
    private $serviceContainer;

    /**
     * LayoutService constructor.
     * @param $serviceContainer
     */
    public function __construct($serviceContainer)
	{
	    $this->serviceContainer = $serviceContainer;

	    foreach ($this->getConfig() as $layoutClass) {
            $this->layouts[] = new $layoutClass;
        }
	}
	
	public function getLayouts()
    {
        return $this->layouts;
    }
    
    /**
     * @param string $code
     * @return MixedResponse
     */
    public function getLayout(string $code)
    {
        $layoutResponse = new MixedResponse();
    
        $layoutResponse->setData(false);
        
        /** @var LayoutInterface $layout */
        foreach ($this->layouts as $layout) {
            if ($code === $layout->getCode()) {
                $layoutResponse->setData($layout);
                break;
            }
        }
        
        return $layoutResponse;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        if (true === $this->serviceContainer->hasParameter('layouts')) {
            return $this->serviceContainer->getParameter('layouts');
        }
    }
}
