<?php
namespace Beaver\BackendBundle\Controller\Rest;

use Beaver\BackendBundle\Controller\ControllerBase;
use Beaver\BackendBundle\Form\BlockFormType;
use Beaver\CoreBundle\Response\BaseResponse;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;

/**
 * Class PageController
 * @package Beaver\BackendBundle\Controller
 */
class PageController extends ControllerBase
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function dropAction(Request $request)
    {
        $block = $request->get('block');
    
        $deleteResponse = $this->get('beaver_core.block')->delete($block);
    
        return new JsonResponse([
            'status'    => $deleteResponse->isSuccess()
        ]);
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function publishAction(Request $request)
    {
        $page = $request->get('page');
        
        $publishResponse = $this->get('beaver_core.page')->publish($page);
    
        $htmlContent = false;
        if (BaseResponse::SUCCESS === $publishResponse->isSuccess()) {
            $htmlContent = $publishResponse->getData()->toArray();
        }
        
        return new JsonResponse([
            'status'    => $publishResponse->isSuccess(),
            'data'      => $htmlContent
        ]);
    }
}
