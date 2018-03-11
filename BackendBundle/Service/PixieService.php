<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/03/2018
 * Time: 22:06
 */

namespace Beaver\BackendBundle\Service;

use Beaver\CoreBundle\Response\BooleanResponse;
use PHPixie\Image;
use Beaver\BackendBundle\Service\FileSystemService;

/**
 * Class ToolsService
 *
 * @package Beaver\BackendBundle\Service
 */
class PixieService extends Image
{
	/** @var FileSystemService */
	private $filesystem;
	
	/**
	 * PixieService constructor.
	 *
	 * @param FileSystemService $filesystem
	 */
	public function __construct(FileSystemService $filesystem)
	{
		parent::__construct();
		$this->filesystem = $filesystem;
	}
	
	/**
	 * @param string $image
	 * @param int    $width
	 * @param int    $height
	 * @param int    $x
	 * @param int    $y
	 *
	 * @return \Beaver\CoreBundle\Response\BooleanResponse
	 */
	public function cropImage(string $image, int $width, int $height, int $x, int $y)
	{
		$cropResponse = new BooleanResponse();
		
		try {
			$image = $this->filesystem->getRealPath($image);
			$this->read($image)->crop($width, $height, $x, $y)->save($image);
		} catch (\Exception $exception) {
			$cropResponse->setError($exception->getMessage());
		}
		
		return $cropResponse;
	}
}