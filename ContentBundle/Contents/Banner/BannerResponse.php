<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/3/17
 * Time: 00:49
 */

namespace Beaver\ContentBundle\Contents\Banner;

use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Class BannerResponse
 * @package Beaver\ContentBundle\Banner
 */
class BannerResponse extends BaseResponse
{
    /**
     * @param \Beaver\ContentBundle\Entity\Banner $data
     * @return $this
     */
    public function setData($data)
    {
        if (false === $data instanceof \Beaver\ContentBundle\Entity\Banner)
        {
            $this->setError('Expected a \Beaver\ContentBundle\Entity\Banner');
            $this->setStatus(BaseResponse::FAIL);
            return $this;
        }

        $banner = new Banner();
        $banner
            ->setId($data->getId())
            ->setName($data->getName())
            ->setText($data->getText())
            ->setPublished($data->getPublished())
        ;

        $this->data = $banner;

        return $this;
    }
}