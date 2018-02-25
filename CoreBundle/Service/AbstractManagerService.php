<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 21:10
 */

namespace Beaver\CoreBundle\Service;

use Beaver\CoreBundle\Manager\Interfaces\ComponentManagerInterface;
use Beaver\CoreBundle\Service\Interfaces\ManagerServiceInterface;


/**
 * Class AbstractManagerService
 * @package Beaver\BackendBundle\Service
 */
abstract class AbstractManagerService implements ManagerServiceInterface
{
    /**
     * Create the instance of manager class.
     * This service is oriented for Components Services, Resources Services and Containts Services
     *
     * @param $type
     * @return ComponentManagerInterface
     */
    abstract public function getManager($type);
}