<?php
namespace Beaver\BackendBundle\Controller\Rest;

use Beaver\BackendBundle\Controller\ControllerBase;
use Beaver\BackendBundle\Form\BlockFormType;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Response\MixedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BlockController
 * @package Beaver\BackendBundle\Controller
 */
class BlockController extends ControllerBase
{
    /**
     * Returns block form.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function form(Request $request)
    {
        $page = $request->get('page');
        $area = $request->get('area');
        
        $formType = $this->get('form.factory')->create(BlockFormType::class, [
            'page'  => $page,
            'area'  => $area
        ]);
        
        $htmlContent = $this->render(
            '@Backend/Forms/Modal/block.html.twig', [
                'form'  => $formType->createView()
        ])->getContent();
        
        $formResponse = new MixedResponse();
	    return $formResponse->setData($htmlContent)->toJsonResponse();
    }
	
	/**
	 * Create new block for page area.
	 *
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function save(Request $request)
	{
		$formType = $this->get('form.factory')->create(BlockFormType::class);
		
		if (true === $request->isMethod(Request::METHOD_POST)) {
			$formType->handleRequest($request);
			$blockResponse = $this->get('beaver.core.block')->save($formType);
		}
		
		if (BaseResponse::SUCCESS === $blockResponse->isSuccess()) {
			$htmlContent = $this->renderView(
				$blockResponse->getData()->getLayout(), [
				'block' => $blockResponse->getData()
			]);
			$blockResponse->setData($htmlContent);
		}
		
		return $blockResponse->toJsonResponse();
	}
	
	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function block($id, Request $request)
	{
		$blockResponse = $this->get('beaver.core.block')->get($id);
		$htmlContent = '';
		if (BaseResponse::SUCCESS === $blockResponse->isSuccess()) {
			$htmlContent = $this->render(
				$blockResponse->getData()->getLayout(), [
				'block' => $blockResponse->getData()
			]);
			$blockResponse->setData($htmlContent);
		}
		
		return $blockResponse->toJsonResponse();
	}
	
	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function move($id, $blockToReplace, Request $request)
	{
		/** @var BaseResponse $moveResponse */
		$moveResponse = $this->get('beaver.core.block')->moveBlock($id, $blockToReplace);
		
		return $moveResponse->toJsonResponse();
	}
	
	/**
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function publish($id)
	{
		/** @var BaseResponse $publishResponse */
		$publishResponse = $this->get('beaver.core.block')->publish($id);
		
		if (BaseResponse::FAIL === $publishResponse->isSuccess()) {
			return $publishResponse->toJsonResponse();
		}
		
		$htmlContent = $this->render(
			$publishResponse->getData()->getLayout(), [
				'block' => $publishResponse->getData()
			])->getContent();
		
		$mixedResponse = new MixedResponse();
		return $mixedResponse->setData($htmlContent)->toJsonResponse();
	}
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function drop($id, Request $request)
    {
        $deleteResponse = $this->get('beaver.core.block')->delete($id);
	    return $deleteResponse->toJsonResponse();
    }
}
