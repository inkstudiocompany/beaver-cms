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
		
		$toArrayMethod = 'return [';
		
		if (false === empty($properties)) {
			foreach ($properties as $name => $value) {
				$set = 'set'.ucfirst(strtolower($name));
				$get = 'get'.ucfirst(strtolower($name));
				
				if (false === property_exists(Content::class, $name)) {
					$classCode .= 'private $'.$name.';';
				}
				
				if (false === method_exists(Content::class, $get)) {
					$classCode .= 'public function ' . $get . '() { return $this->'.$name.'; }';
				}
				
				if (false === method_exists(Content::class, $set)) {
					$classCode .= 'public function ' . $set . '($'.$name.') { $this->'.$name.' = $'.$name.'; return $this; }';
				}
				
				$toArrayMethod .= '"' . $name . '" => $this->' . $get . '(),';
			}
		}
		
		$toArrayMethod .= '];';
		
		$classCode .= 'public function toArray() { ' . $toArrayMethod . ' }';
		$classCode .= '}';
		
		eval($classCode);
		
		return new $className;
	}
}