<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 20:30
 */

namespace Beaver\CoreBundle\Response;

use Beaver\CoreBundle\Entity\Page as PageEntity;
use Beaver\CoreBundle\Model\Page\Page;

/**
 * Prepare the response for a entity Page
 *
 * Class PageResponse
 * @package Beaver\CoreBundle\Response
 */
class PageResponse extends BaseResponse
{
    
    /**
     * @param PageEntity $data
     * @return $this
     */
    public function setData($data)
    {
        if (false === $data instanceof PageEntity)
        {
            $this->setError('Expected a Beaver\CoreBundle\Entity\Page');
            return $this;
        }
    
        $page = new Page();
        $page
            ->setId($data->getId())
            ->setPublished($data->getPublished())
            ->setName($data->getName())
            ->setSlug($data->getSlug())
            ->setLayout($data->getLayout())
            ->setTheme($data->getTheme())
        ;
        
        $this->data = $page;
    
        return $this;
    }
}