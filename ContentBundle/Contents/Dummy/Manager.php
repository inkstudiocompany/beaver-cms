<?php
namespace Beaver\ContentBundle\Contents\Dummy;

use Beaver\ContentBundle\Base\Contents\AbstractContentManager;
use Beaver\ContentBundle\Base\Entity\ContentEntityInterface;
use Beaver\ContentBundle\Entity\Dummy;
use Beaver\ContentBundle\Service\Response\ContentResponse;
use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Class BannerManager
 * @package Beaver\ContentBundle\Banner
 */
class Manager extends AbstractContentManager
{
    /** @return string */
	public static function Type()
	{
		return 'dummy';
	}
	
	/**
	 * Returns the formtype for creation/edition of a content.
	 *
	 * @return mixed
	 */
	public function FormType()
	{
		return Type::class;
	}
	
	/**
	 * Return a repository for the content.
	 *
	 * @return \Beaver\ContentBundle\Base\Entity\AbstractContentEntity
	 */
	public function Repository()
	{
		return Dummy::class;
	}

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
}
