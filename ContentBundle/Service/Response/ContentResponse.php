<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 25/02/2018
 * Time: 15:41
 */

namespace Beaver\ContentBundle\Service\Response;

use Beaver\ContentBundle\Base\Contents\Content;
use Beaver\ContentBundle\Base\Contents\ContentFactory;
use Beaver\ContentBundle\Base\Entity\AbstractContentEntity;
use Beaver\ContentBundle\Base\Entity\ContentEntityInterface;
use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Class ContentResponse
 *
 * @package Beaver\ContentBundle\Service\Response
 */
class ContentResponse extends BaseResponse
{
	/**
	 * @param AbstractContentEntity $data
	 *
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function setData($data)
	{
		$dataContent = [];
		
		$reflection = new \ReflectionClass($data);
		
		foreach ($reflection->getProperties() as $property) {
			$dataContent[$property->getName()] = $data->__get($property->name);
		}
		
		/** @var Content $content */
		$content = ContentFactory::newClass($reflection->getShortName(), $dataContent);
		
		foreach ($dataContent as $name => $value) {
			$content->{'set'.ucfirst(strtolower($name))}($value);
		}
		
		$content->setContentName(strip_tags($data->getContentName()));
		
		$this->data = $content;
		
		return $this;
	}
}