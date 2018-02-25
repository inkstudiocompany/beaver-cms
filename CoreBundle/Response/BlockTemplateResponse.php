<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 20:30
 */

namespace Beaver\CoreBundle\Response;

use Beaver\CoreBundle\Entity\BlockTemplate as BlockTemplateEntity;
use Beaver\CoreBundle\Model\Configuration\BlockTemplate;

/**
 * Create response with BlockTemplate Model.
 *
 * Class BlockTemplateResponse
 * @package Beaver\CoreBundle\Response
 */
class BlockTemplateResponse extends BaseResponse
{
    
    /**
     * @param BlockTemplateEntity $data
     * @return $this
     */
    public function setData($data)
    {
        if (false === $data instanceof BlockTemplateEntity)
        {
            $this->setError('Expected a Beaver\CoreBundle\Entity\BlockTemplateEntity');
            return $this;
        }
    
        $block = new BlockTemplate();
        $block
            ->setId($data->getId())
            ->setName($data->getName())
            ->setView($data->getView())
        ;
        
        $this->data = $block;
    
        return $this;
    }
}