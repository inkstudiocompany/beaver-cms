<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/1/17
 * Time: 08:54
 */

namespace Beaver\CoreBundle\Model\Page\Layout;

use Beaver\CoreBundle\Model\Interfaces\LayoutInterface;
use Beaver\CoreBundle\Model\Page\Area;

/**
 * Class DefaultLayout
 * @package Beaver\CoreBundle\Model\Page\Layout
 */
class DefaultLayout implements LayoutInterface
{
    /** @var array $areas */
    protected $areas;
    
    /**
     * DefaultLayout constructor.
     */
    public function __construct()
    {
        $this->areas = [
            'header-area'    => new Area('header-area', []),
            'body-area'      => new Area('body-area', []),
            'footer-area'    => new Area('footer-area', [])
        ];
    }
    
    /**
     * Returns a code of Layout. The code is the index of layouts,
     * this must be unique.
     *
     * We propose the follow syntaxis {bundleName}.{layoutName}
     *
     * @return string
     */
    public function getCode()
    {
        return 'beaver.defaultLayout';
    }
    
    /**
     * Returns a string of name's layout.
     *
     * @return string
     */
    public function getName()
    {
        return 'Default Layout';
    }
    
    /**
     * Returns a string of twig (view) path.
     *
     * @return string
     */
    public function getPath()
    {
        return '@Core/Layouts/Page/default-layout.html.twig';
    }
    
    /**
     * Returns an array of Areas.
     *
     * @return array The areas
     */
    public function getAreas()
    {
        return $this->areas;
    }
	
	/**
	 * @param string $areaName
	 *
	 * @return \Beaver\CoreBundle\Model\Page\Area|mixed
	 */
    public function getArea(string $areaName)
    {
        return $this->areas[$areaName];
    }
}
