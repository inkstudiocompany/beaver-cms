<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 25/02/2018
 * Time: 21:05
 */

namespace Beaver\ContentBundle\Base\Contents;

class ContentFactory
{
	public static function newClass($className, $properties)
	{
		if (true === class_exists($className)) {
			return new $className;
		}
		
		$classCode = 'class ' . $className . ' extends Beaver\ContentBundle\Base\Contents\Content {';
		
		if (false === empty($properties)) {
			foreach ($properties as $name => $value) {
				$set = 'set'.ucfirst(strtolower($name));
				$get = 'get'.ucfirst(strtolower($name));
				
				if (false === property_exists(Content::class, $name)) {
					$classCode .= 'private $'.$name.';';
					$classCode .= 'public function ' . $get . '() { return $this->'.$name.'; }';
					$classCode .= 'public function ' . $set . '($'.$name.') { $this->'.$name.' = $'.$name.'; return $this; }';
				}
			}
		}
		
		$classCode .= '}';
		
		eval($classCode);
		
		return new $className;
	}
}