<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/19/17
 * Time: 21:30
 */
namespace Beaver\CoreBundle\Widgets;

/**
 * Interface WidgetInterface
 * @package Beaver\CoreBundle\Widgets
 */
interface WidgetInterface
{
    /**
     * Returns widget's name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns widget's description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Returns widget's twig.
     *
     * @return string
     */
    public function getView();

    /**
     * Return data for widget view.
     *
     * @return array
     */
    public function getData();
}