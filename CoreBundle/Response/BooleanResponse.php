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
 * Class BooleanResponse
 * @package Beaver\CoreBundle\Response
 */
class BooleanResponse extends BaseResponse
{
    
    /**
     * @param boolean $data
     * @return $this
     */
    public function setData($data)
    {
        if (false === is_bool($data))
        {
            $this->setError('Expected boolean value');
            return $this;
        }
        
        $this->data = $data;
    
        return $this;
    }
}