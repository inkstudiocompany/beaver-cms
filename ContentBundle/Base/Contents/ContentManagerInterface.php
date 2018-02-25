<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/2/17
 * Time: 22:50
 */
namespace Beaver\ContentBundle\Base\Contents;

use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Interface ContentManagerInterface
 * @package Beaver\ContentBundle\Interfaces
 */
interface ContentManagerInterface
{
    /**
     * @param int $page
     * @return array
     */
    public function list($page = 1);

    /**
     * @param $parameters
     * @return mixed
     */
    public function search($parameters);

    /**
     * @param $parameters
     * @return mixed
     */
    public function save($parameters);

    /**
     * @param $parameters
     * @return mixed
     */
    public function update($parameters);

    /**
     * @param $parameters
     * @return mixed
     */
    public function delete($parameters);

    /**
     * @param $parameters
     * @return mixed
     */
    public function get($parameters);

    /**
     * @param $parameters
     * @return mixed
     */
    public function link($parameters);

    /**
     * @return BaseResponse
     */
    public function getResponse();
}
