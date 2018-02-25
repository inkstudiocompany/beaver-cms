<?php
namespace Beaver\BackendBundle\Controller\Rest;

use Beaver\BackendBundle\Controller\ControllerBase;
use Beaver\BackendBundle\Form\WidgetFormType;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Response\BooleanResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WidgetController
 * @package Beaver\BackendBundle\Controller
 */
class WidgetController extends ControllerBase
{
    /**
     * Returns block form.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function newModalAction(Request $request)
    {
        $block  = $request->get('block');
        $size   = $request->get('size');
        $slot   = $request->get('slot');

        $formType = $this->get('form.factory')->create(WidgetFormType::class, [
            'block'         => $block,
            'size'          => $size,
            'slot'          => $slot
        ]);
        
        $htmlContent = $this->renderView(
            '@BeaverBackend/Forms/Modal/widget.html.twig', [
                'form'  => $formType->createView()
        ]);
    
        return new JsonResponse([
            'status'    => true,
            'data'      => $htmlContent
        ]);
    }
    
    /**
     * Create new widget instance for a slot block.
     *
     * @param Request $request
     */
	public function saveAction(Request $request)
    {
        $formType = $this->get('form.factory')->create(WidgetFormType::class, [
            'size' => $request->get('widget_form')['size']
        ]);

        if (true === $request->isMethod(Request::METHOD_POST)) {
            $formType->handleRequest($request);

            /** @var BaseResponse $widgetResponse */
            $widgetResponse = $this->get('beaver_core.widget')->save($formType);
        }
	
	    return $widgetResponse->toJsonResponse();
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function dropAction(Request $request)
    {
        /** @var BooleanResponse $deleteResponse */
        $deleteResponse = $this->get('beaver_core.widget')->delete($request->get('widget'));
	
	    return $deleteResponse->toJsonResponse();
    }
}
