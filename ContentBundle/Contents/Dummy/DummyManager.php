<?php
namespace Beaver\ContentBundle\Contents\Dummy;

use Beaver\ContentBundle\Base\Contents\AbstractContentManager;
use Beaver\ContentBundle\Base\Entity\ContentEntityInterface;
use Beaver\ContentBundle\Entity\Dummy;
use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Class BannerManager
 * @package Beaver\ContentBundle\Banner
 */
class DummyManager extends AbstractContentManager
{
    /** @var  string */
    public $repository = Dummy::class;

    /** @var  string */
    public $formType = DummyType::class;

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
     * @param ContentEntityInterface $entity
     * @param array $data
     */
    public function setEntityData(ContentEntityInterface $entity, $data = [])
    {
        $entity->setAttribute($data['attribute']);
    }


    /**
     * @return BaseResponse
     */
    public function getResponse()
    {
        return new DummyResponse();
    }
	
	/** @return string */
	static function Type()
	{
		return 'dummy';
	}
}
