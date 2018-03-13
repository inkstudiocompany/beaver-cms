<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 12/03/2018
 * Time: 22:37
 */

namespace Beaver\ContentBundle\Controller;

use Beaver\BackendBundle\Controller\ControllerBase;
use Beaver\CoreBundle\Response\BaseResponse;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends ControllerBase
{
	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function gallery()
	{
		return $this->render('@Backend/Backend/gallery.html.twig', [
			'pics' => $this->get('beaver.filesystem')->gallery()->getData()
		]);
	}
	
	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function galleryType(Request $request)
	{
		return $this->render('@Backend/Forms/Modal/image-gallery.html.twig', [
			'pics'      => $this->get('beaver.filesystem')->gallery()->getData(),
			'idType'    => $request->get('idType', '')
		]);
	}
	
	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function upload(Request $request)
	{
		$response = new BaseResponse();
		
		if (false === $request->files->has('file-to-upload')) {
			return $response->setError('No se envío el archivo para subir')->toJsonResponse();
		}
		
		$response = $this->get('beaver.filesystem')->upload($request->files->get('file-to-upload'));
		
		if (BaseResponse::SUCCESS === $response->isSuccess()) {
			$imageView = $this->render('@Backend/Backend/Partials/_image.gallery.html.twig', [
				'image' => $response->getData()
			])->getContent();
			$response->setData($imageView);
		}
		
		return $response->toJsonResponse();
	}
	
	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return mixed
	 */
	public function delete(Request $request)
	{
		return $this->get('beaver.filesystem')
			->delete($request->get('image'))->toJsonResponse();
	}
	
	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function croptool(Request $request)
	{
		return $this->render('@Backend/Forms/crop-tool.html.twig', [
			'image' => $request->get('image', '')
		]);
	}
	
	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function cropsave(Request $request)
	{
		$cropInfo = json_decode($request->get('info'), '');
		return $this->get('pixie')
			->cropImage($cropInfo->image, $cropInfo->width, $cropInfo->height, $cropInfo->x, $cropInfo->y)
			->toJsonResponse();
	}
}