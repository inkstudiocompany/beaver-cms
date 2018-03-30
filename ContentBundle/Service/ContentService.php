<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/7/17
 * Time: 17:46
 */
namespace Beaver\ContentBundle\Service;

use Beaver\BackendBundle\BackendBundle;
use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Response\ArrayResponse;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Response\BooleanResponse;
use Beaver\ContentBundle\Base\Contents\AbstractContentManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\Form;

/**
 * Class ContentService
 * @package Beaver\ContentBundle\Service
 */
class ContentService
{
    /** @var EntityManager $em */
    protected $entityManager;

    /** @var  Container */
    protected $serviceContainer;

    /**
     * ContentService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $serviceContainer)
    {
        $this->entityManager    = $entityManager;
        $this->serviceContainer = $serviceContainer;
    }
    
    /**
     * @return array|mixed
     */
    public function getContents()
    {
        $contents = [];
        if (true === $this->serviceContainer->hasParameter('contents')) {
            foreach ($this->serviceContainer->getParameter('contents') as $content) {
                $contents[$content::Type()] = $content;
            }
        }
        return $contents;
    }

    /**
     * @param $content
     * @return AbstractContentManager
     * @throws \Exception
     */
    public function getContentManager($content)
    {
        $contents = $this->getContents();
        if (false === isset($contents[$content])) {
            throw new \Exception('Content Manager no encontrado.');
        }
        /** @var AbstractContentManager $contentManager */
        $contentManager = $contents[$content]::manager();
        return $contentManager->setServices($this->entityManager);
    }

    public function search()
    {

    }

    /**
     * @param $content
     * @return ArrayResponse
     */
    public function getContentsByType($content)
    {
        $listResponse = new ArrayResponse();

        /** @var AbstractContentManager $contentManager */
        $contentManager = $this->getContentManager($content);

        /** @var BaseResponse $contentResponse */
        $contentResponse = $contentManager->getResponse();
        foreach ($contentManager->list() as $contentEntity)
        {
	        if (BaseResponse::SUCCESS === $contentResponse->setData($contentEntity)->isSuccess()) {
		        if (BackendBundle::BUNDLE !== $this->serviceContainer->get('beaver.core.context')->getBundle()) {
			        if (Statutory::PUBLISHED === $contentResponse->getData()->isPublished()) {
				        $listResponse->addItem($contentResponse->getData());
			        }
		        } elseif (BackendBundle::BUNDLE === $this->serviceContainer->get('beaver.core.context')->getBundle()) {
			        $listResponse->addItem($contentResponse->getData());
		        }
		
		        $contentResponse->reset();
	        }
        }

        return $listResponse;
    }

    /**
     * @param $content
     * @param $id
     * @return $this|mixed
     */
    public function get($content, $id)
    {
        /** @var AbstractContentManager $contentManager */
        $contentManager = $this->getContentManager($content);

        /** @var BaseResponse $contentResponse */
        $contentResponse = $contentManager->getResponse();

        $contentEntity = $contentManager->get(['id' => $id]);

        if (!$contentEntity) {
            return $contentResponse->setError(Error::ITEM_NOT_FOUND_MESSAGE);
        }

        return $contentResponse->setData($contentEntity);
    }

    /**
     * @param Form $form
     * @return BaseResponse
     */
    public function save(Form $form)
    {
        /** @var AbstractContentManager $contentManager */
        $contentManager = $this->getContentManager($form->get('type')->getData());

        /** @var BaseResponse $contentResponse */
        $contentResponse = $contentManager->getResponse();

        if (true === $form->isValid()) {
            $contentEntity = $contentManager->save($form->getData());
        }

        return $contentResponse->setData($contentEntity);
    }

    /**
     * @param $content
     * @param $id
     * @return BooleanResponse|mixed
     */
    public function delete($content, $id)
    {
        $deleteResponse = new BooleanResponse();
        /** @var AbstractContentManager $contentManager */
        $contentManager = $this->getContentManager($content);

        if (false === $contentManager->delete($id)) {
            return $deleteResponse->setError('Ocurrió un error al eliminar el contenido.');
        }

        return $deleteResponse;
    }

    public function link()
    {

    }

    /**
     * @param $content
     * @param null $data
     * @param array $options
     * @return \Symfony\Component\Form\Form
     */
    public function form($content, $data = null, array $options = array())
    {
        /** @var AbstractContentManager $contentManager */
        $contentManager = $this->getContentManager($content);

        return $contentManager->form($this->serviceContainer->get('form.factory'), $data, $options);
    }
}