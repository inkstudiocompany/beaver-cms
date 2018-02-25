<?php
namespace Beaver\ContentBundle\Contents\Banner;

use Beaver\ContentBundle\Base\Contents\AbstractContentManager;
use Beaver\ContentBundle\Base\Entity\ContentEntityInterface;
use Beaver\ContentBundle\Entity\Banner;
use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Class BannerManager
 * @package Beaver\ContentBundle\Banner
 */
class BannerManager extends AbstractContentManager
{
    /** @var string  */
    public $formType      = BannerType::class;

    /** @var string  */
    public $repository    = Banner::class;

    /**
     * This method performs a search by applying the filters specified in the parameters.
     *
     * @param $parameters
     * @return mixed
     */
    public function search($parameters)
    {
        // TODO: Implement search() method.
    }

    /**
     * @param Banner $entity
     * @param array $data
     */
    public function setEntityData(ContentEntityInterface $entity, $data = [])
    {
        $entity
            ->setName($data['name'])
            ->setText($data['text']);
    }

    /**
     * @return BaseResponse
     */
    public function getResponse()
    {
        return new BannerResponse();
    }
}
