<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 03/03/2018
 * Time: 13:39
 */

namespace Beaver\BackendBundle\Service;


use Beaver\CoreBundle\Response\ArrayResponse;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Response\BooleanResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileSystemService
 *
 * @package Beaver\BackendBundle\Service
 */
class FileSystemService
{
	/** @var string  */
	private $publicPath = '';
	
	/** @var string  */
	private $galleryDir = 'gallery';
	
	/**
	 * FileSystemService constructor.
	 *
	 * @param string $projectDir
	 */
	public function __construct($projectDir = '')
	{
		$this->publicPath = $projectDir . '/public/';
	}
	
	/**
	 * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
	 *
	 * @return \Beaver\CoreBundle\Response\BaseResponse
	 */
	public function upload(UploadedFile $file)
	{
		$uploadResponse = new BaseResponse();
		
		try {
			$fileFolder = $this->galleryDir .'/' . $file->guessExtension();
			
			$fileSystem = new Filesystem();
			if (false === $fileSystem->exists($this->publicPath . $fileFolder)) {
				$fileSystem->mkdir([$this->galleryDir, $this->publicPath . $fileFolder]);
			}
			
			/** @var \Symfony\Component\HttpFoundation\File\File $file */
			$file = $file->move($this->publicPath . $fileFolder , $file->getClientOriginalName());
			$uploadResponse->setData('/' . $fileFolder . '/' . $file->getFilename());
		} catch (\Exception $exception) {
			$uploadResponse->setError($exception->getMessage());
		}
		
		return $uploadResponse;
	}
	
	/**
	 * @return \Beaver\CoreBundle\Response\ArrayResponse
	 */
	public function gallery()
	{
		$galleryResponse = new ArrayResponse();
		
		try {
			$finder = new Finder();
			
			$finder->files()->in($this->publicPath . $this->galleryDir);
			
			foreach ($finder as $file) {
				$galleryResponse->addItem('/' . $this->galleryDir . '/' . $file->getRelativePathname());
			}
		} catch (\Exception $exception) {
			$galleryResponse->setError($exception->getMessage());
		}
		
		return $galleryResponse;
	}
	
	/**
	 * @param $file
	 *
	 * @return \Beaver\CoreBundle\Response\BooleanResponse
	 */
	public function delete($file)
	{
		$deleteResponse = new BooleanResponse();
		
		try {
			$fileSystem = new Filesystem();
			
			if (true === $fileSystem->exists($this->publicPath . $file)) {
				$fileSystem->remove($this->publicPath . $file);
			}
		} catch (\Exception $exception) {
			$deleteResponse->setError($exception->getMessage());
		}
		
		return $deleteResponse;
	}
	
	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function getRealPath(string $path): string
	{
		return $this->publicPath . $path;
	}
}