<?php

namespace Beaver\BackendBundle\Controller;

use Beaver\BackendBundle\Form\PageFormType;
use Beaver\CoreBundle\Response\ArrayResponse;
use Beaver\CoreBundle\Response\BaseResponse;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContentController
 * @package Beaver\BackendBundle\Controller
 */
class ContentController extends ControllerBase
{
	/**
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function list(Request $request)
	{
	    $content = $request->get('content');

	    /** @var ArrayResponse $contentResponse */
	    $contentResponse = $this->get('beaver.content')->getContentsByType($content);

	    return $this->render('@Backend/Backend/content-list.html.twig', [
	        'content'   => $contentResponse->getData(),
            'type'      => $content
        ]);
	}
	
	/**
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function new(Request $request)
    {
        $content = $request->get('content');

        /** @var Form $form */
        $form = $this->get('beaver.content')->form($content);

        $form->handleRequest($request);

        if (true === $form->isSubmitted()) {
            $saveResponse = $this->get('beaver.content')->save($form);
            if (BaseResponse::SUCCESS === $saveResponse->isSuccess()) {
                return $this->redirectToRoute('beaver.backend.edit', [
                    'content'   => $content,
                    'id'        => $saveResponse->getData()->getId(),
                    'created'   => true
                ]);
            }
        }

        return $this->render($this->get('beaver.content')->getContentManager($content)->formView(), [
            'form'  => $form->createView(),
            'type'  => $content
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request)
    {
        $content = $request->get('content');

        $data = [];
        /** @var BaseResponse $contentResponse */
        $contentResponse = $this->get('beaver.content')->get($content, $request->get('id'));
        if (BaseResponse::SUCCESS === $contentResponse->isSuccess()) {
            $data = $contentResponse->getData()->toArray();
        }

        /** @var Form $form */
        $form = $this->get('beaver.content')->form($content, $data);

        $form->handleRequest($request);

        $params = [
            'form'      => $form->createView(),
            'type'      => $content
        ];

        if ($request->get('created')) {
            $params['status']   = BaseResponse::SUCCESS;
            $params['message']  = 'Contenido creado correctamente!';
        }

        if (true === $form->isSubmitted()) {
            $saveResponse = $this->get('beaver.content')->save($form);
            $params['status']   = $saveResponse->isSuccess();
            if (BaseResponse::FAIL === $saveResponse->isSuccess()) {
                $params['message']  = $saveResponse->getError();
            }
        }
        
        return $this->render('@Backend/Forms/content.html.twig', $params);
    }
	
	/**
	 * @param Request $request
	 *
	 * @return RedirectResponse
	 */
    public function delete(Request $request)
    {
        $content = $request->get('content');

        $contentResponse = $this->get('beaver.content')->delete($content, $request->get('id'));

        if (BaseResponse::SUCCESS === $contentResponse->isSuccess()) {
            return $this->redirectToRoute('beaver.backend.contents', ['content' => $content]);
        }
    }
}
