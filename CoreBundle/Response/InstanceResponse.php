<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 20:30
 */

namespace Beaver\CoreBundle\Response;

use Beaver\CoreBundle\Entity\Block as BlockEntity;
use Beaver\CoreBundle\Model\Page\Block;

/**
 * Create response with Instance Model.
 *
 * Class InstanceResponse
 * @package Beaver\CoreBundle\Response
 */
class BlockResponse extends BaseResponse
{
    /**
     * @param BlockEntity $data
     * @return $this
     */
    public function setData($data)
    {
        if (false === $data instanceof BlockEntity)
        {
            $this->setError('Expected a Beaver\CoreBundle\Entity\Block');
            return $this;
        }
    
        $block = new Block();
        $block
            ->setId($data->getId())
            ->setPublished($data->getPublished())
            ->setPage($data->getPage())
            ->setArea($data->getArea())
            ->setBlockTemplate($data->getBlockTemplate())
            ->setOrder($data->getOrder())
        ;

        $this->data = $block;
    
        return $this;
    }
}