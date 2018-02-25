<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 20:30
 */

namespace Beaver\CoreBundle\Response;

use Beaver\CoreBundle\Entity\Page as PageEntity;
use Beaver\CoreBundle\Model\PageComponent\Page;

/**
 * Prepare the response for a entity Page
 *
 * Class PageResponse
 * @package Beaver\CoreBundle\Response
 */
class ArrayResponse extends BaseResponse
{
    public function __construct()
    {
        $this->data = array();
    }
    
    public function setData($data)
    {
        if (false === is_array($data))
        {
            $this->setStatus(BaseResponse::FAIL);
            throw new \Exception('Expected a Array.');
        }
    
        $this->data = $data;
    }
    
    public function addItem($item)
    {
        if (false === in_array($item, $this->data)) {
            array_push($this->data, $item);
        }
        return $this;
    }
    
    public function removeItem($item)
    {
        if (true === in_array($item, $this->data)) {
            foreach ($this->data as $key => $dataItem) {
                if ($dataItem === $item) {
                    unset($this->data[$key]);
                }
            }
        }
        return $this;
    }
    
    public function findItem($key)
    {
        if (false === isset($this->data[$key])) {
            return false;
        }
        return $this->data[$key];
    }
}