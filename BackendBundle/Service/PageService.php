<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 21:10
 */

namespace Beaver\BackendBundle\Service;

use Beaver\CoreBundle\Entity\Page;
use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Response\PageResponse;
use Beaver\CoreBundle\Service\PageService as ServiceBase;
use Symfony\Component\Form\FormInterface;

/**
 * Class PageService
 * @package Beaver\BackendBundle\Service
 */
class PageService extends ServiceBase
{
    /**
     * @param FormInterface $form
     * @return PageResponse|mixed
     */
    public function process(FormInterface $form)
    {
        $pageResponse = new PageResponse();
        
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $pageResponse->setError('The form is not valid.');
        }
    
        // Gets existing record
        if (true === $form->isSubmitted() && true === $form->has('id')) {
            $pageEntity = $this->entityManager->getRepository('BeaverCoreBundle:Page')
                ->find($form->get('id')->getData())
            ;
        }
    
        // Create new record
        if (false === $form->has('id')) {
            $pageEntity = new Page();
        }
        
        try {
            $isPublished = (true === $form->has('published')) ? $form->get('published')->getData() :
                Statutory::UNPUBLISHED;
            
            $pageEntity
                ->setName($form->get('name')->getData())
                ->setSlug($form->get('slug')->getData())
                ->setLayout($form->get('layout')->getData())
                ->setTheme($form->get('theme')->getData())
                ->setPublished($isPublished)
            ;
            
            $this->entityManager->persist($pageEntity);
            $this->entityManager->flush();
            $pageResponse->setData($pageEntity);
        } catch (\Exception $exception) {
            $pageResponse->setError($exception->getMessage());
        }
        
        return $pageResponse;
    }
    
    /**
     * Return a model from a page record.
     *
     * @param integer $pageId
     * @return PageResponse|mixed|void
     */
    public function getById($pageId)
    {
        $pageResponse = new PageResponse();
        
        try {
            $pageEntity = $this->entityManager->getRepository(Page::class)
                ->find($pageId)
            ;
            
            if (!$pageEntity) {
                return $pageResponse->setStatus('No se encontró el registro');
            }
            
            $pageResponse->setData($pageEntity);
        } catch (\Exception $exception) {
            $pageResponse->setError($exception->getMessage());
        }
        
        return $pageResponse;
    }
}