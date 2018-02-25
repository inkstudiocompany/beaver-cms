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
 * Class LeftSidebarLayout
 *
 * @package Beaver\CoreBundle\Model\Page\Layout
 */
class LeftSidebarLayout implements LayoutInterface
{
    /** @var array $areas */
    protected $areas;
    
    /**
     * DefaultLayout constructor.
     */
    public function __construct()
    {
        $this->areas = [
            'header'             => new Area('header', []),
            'left-container'    => new Area('left-container', []),
            'sidebar'           => new Area('sidebar', [])
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
        return 'beaver.leftSidebarLayout';
    }
    
    /**
     * Returns a string of name's layout.
     *
     * @return string
     */
    public function getName()
    {
        return 'Left Sidebar Layout';
    }
    
    /**
     * Returns a string of twig (view) path.
     *
     * @return string
     */
    public function getPath()
    {
        return '@Core/Layouts/Page/right-sidebar.html.twig';
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
     * @param $areaName
     *
     * @return Area
     */
    public function getArea(string $areaName)
    {
        return $this->areas[$areaName];
    }
}
