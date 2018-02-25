<?php
namespace Beaver\CoreBundle\Manager\Interfaces;
use Beaver\CoreBundle\Model\Interfaces\ModelInterface;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Service\ContextService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

/**
 * Interface ComponentManagerInterface
 * @package Beaver\CoreBundle\Manager\Interfaces
 */
interface ComponentManagerInterface
{
    /**
     * Component Manager must implement singleton pattern.
     *
     * @return self
     */
    static function manager();

    /**
     * @param EntityManager $entityManager
     * @param ContextService $contextService
     * @param FormFactory $formFactory
     * @return mixed
     */
    public function setServices(EntityManager $entityManager);

    /**
     * Return The Response Object.
     *
     * @return BaseResponse
     */
    public function getResponse();


    /**
     * Return the EntityClass.
     *
     * @return mixed
     */
    public function getEntity();


    /**
     * This method performs a search by applying the filters specified in the parameters.
     *
     * @param $parameters
     * @return mixed
     */
    public function search($parameters);

    /**
     * @return mixed
     */
    public function list();

    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

}
