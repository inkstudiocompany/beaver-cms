<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 20:30
 */

namespace Beaver\CoreBundle\Response;

/**
 * Prepare the response for any data
 *
 * Class MixedResponse
 * @package Beaver\CoreBundle\Response
 */
class MixedResponse extends BaseResponse
{
    
    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }
}