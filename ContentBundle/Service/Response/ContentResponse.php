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
use Beaver\CoreBundle\Response\BaseResponse;

/**
 * Class ContentResponse
 *
 * @package Beaver\ContentBundle\Service\Response
 */
class ContentResponse extends BaseResponse
{
	/**
	 * @param $data
	 *
	 * @return $this
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
		
		$this->data = $content;
		
		return $this;
	}
}