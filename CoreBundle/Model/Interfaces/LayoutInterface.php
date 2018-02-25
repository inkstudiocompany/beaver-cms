<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 6/3/17
 * Time: 15:51
 */

namespace Beaver\CoreBundle\Model\Interfaces;

/**
 * Interface LayoutInterface
 *
 * @package Beaver\CoreBundle\Model\Interfaces
 */
interface LayoutInterface
{
    /**
     * Returns a code of Layout. The code is the index of layouts,
     * this must be unique.
     *
     * We propose the follow syntaxis {bundleName}.{layoutName}
     *
     * @return string
     */
    public function getCode();
    
    /**
     * Returns a string of name's layout.
     *
     * @return string
     */
    public function getName();
    
    /**
     * Returns a string of twig (view) path.
     *
     * @return string
     */
    public function getPath();
    
    /**
     * Returns an array of Areas.
     *
     * @return array The areas
     */
    public function getAreas();
	
	/**
	 * Returns an area from layout.
	 *
	 * @param $areaName
	 *
	 * @return \Beaver\CoreBundle\Model\Page\Area
	 */
    public function getArea(string $areaName);
}