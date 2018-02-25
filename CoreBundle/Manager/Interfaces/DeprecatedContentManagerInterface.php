<?php
namespace Beaver\CoreBundle\Manager\Interfaces;
use Beaver\CoreBundle\Model\Interfaces\ModelInterface;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Service\ContextService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

/**
 * Interface ContentManagerInterface
 * @package Beaver\CoreBundle\Manager\Interfaces
 */
interface ContentManagerInterface
{
    /**
     * Component Manager must implement singleton pattern.
     *
     * @return self
     */
    static function manager();

    /**
     * @param EntityManager $entityManager
     * @return mixed
     */
    public function setServices(EntityManager $entityManager);

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
    public function list($page = 1);

    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    public function save();

    public function delete();

    public function form(FormFactory $formFactory, $data = null, array $options = array());

    /**
     * @return BaseResponse
     */
    public function getResponse();
}
