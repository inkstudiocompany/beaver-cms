<?php

namespace Beaver\BackendBundle\Controller;

use Beaver\BackendBundle\Form\PageFormType;
use Beaver\CoreBundle\Response\BaseResponse;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BackendController
 * @package Beaver\BackendBundle\Controller
 */
class BackendController extends ControllerBase
{
    /**
     * @return Response
     */
	public function index()
	{
	    return $this->render('@Backend/Backend/home.html.twig');
	}
    
    /**
     * @return Response
     * @throws \Exception
     */
	public function pages()
	{
	    $pagesResponse = $this->get('beaver.backend.page')->getPages();
	    
	    return $this->render(
            '@Backend/Backend/pages-list.html.twig', [
		    'pages' => $pagesResponse->getData()
        ]);
	}
    
    /**
     * @param Request $request
     * @return Response
     */
	public function page(Request $request)
    {
        $success = null;
    
        if (!$request->get('id')) {
            $pageFormType = $this->get('form.factory')->create(PageFormType::class);
        }
    
        if ($pageId = $request->get('id')) {
            $pageResponse = $this->get('beaver.backend.page')->getById($pageId);
        
            if (BaseResponse::FAIL === $pageResponse->isSuccess()) {
                throw new Exception($pageResponse->getError());
            }
	        $pageFormType = $this->get('form.factory')
		        ->create(PageFormType::class, $pageResponse->getData()->toArray());
        }
        
        if (true === $request->isMethod(Request::METHOD_POST)) {
            $pageFormType->handleRequest($request);
    
            $pageResponse = $this->get('beaver.backend.page')->process($pageFormType);
            
            if ($pageResponse->isSuccess()) {
                $this->redirectToRoute('beaver.backend.page.edit', [
                	'id' => $pageResponse->getData()->getId()
                ]);
            }
            
            $success = $pageResponse->isSuccess();
        }
	    
        return $this->render('@Backend/Forms/page.html.twig', [
            'form'      => $pageFormType->createView(),
            'success'   => $success
        ]);
    }
}
