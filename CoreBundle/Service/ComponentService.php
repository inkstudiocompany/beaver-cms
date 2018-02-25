<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 19:56
 */

namespace Beaver\CoreBundle\Service;

use Beaver\CoreBundle\Manager\Base\AbstractComponentManager;
use Beaver\CoreBundle\Manager\BlockManager;
use Beaver\CoreBundle\Manager\Interfaces\ComponentManagerInterface;
use Beaver\CoreBundle\Manager\WidgetManager;
use Beaver\CoreBundle\Response\ArrayResponse;
use Beaver\CoreBundle\Response\BaseResponse;
use Doctrine\ORM\EntityManager;

/**
 * Class ComponentService
 * @package Beaver\CoreBundle\Service
 *
 * Servicio para el manejo de páginas
 */
class ComponentService
{
    const BLOCKS    = 'BLOCKS';
    const WIDGETS   = 'WIDGETS';

    /** @var EntityManager $em */
	protected $entityManager;

    /** @var  ContextService */
    protected $contextService;

    /**
     * ComponentService constructor.
     * @param EntityManager $entityManager
     */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager    = $entityManager;
	}

    /**
     * Create the instance of manager class.
     * This service is oriented for Components Services, Resources Services and Containts Services
     *
     * @param $type
     * @return ComponentManagerInterface
     */
    public function getManager($type)
    {
        $manager = false;

        if (!$type) {
            throw new \Exception('Type component is not valid.', 400);
        }

        switch (strtoupper($type)) {
            case 'WIDGETS':
                $manager = WidgetManager::manager();
                break;

            case 'BLOCKS':
                $manager = BlockManager::manager();
                break;
        }

        return $manager->setServices($this->entityManager);
    }

    /**
     * @param $type
     * @return ArrayResponse
     */
    public function components($type)
    {
        $arrayResponse = new ArrayResponse();

        /** @var AbstractComponentManager $manager */
        $manager = $this->getManager($type);

        /** @var BaseResponse $response */
        $response = $manager->getResponse();
        foreach ($manager->list() as $entity) {
            if (BaseResponse::SUCCESS === $response->setData($entity)->isSuccess()) {
                $arrayResponse->addItem($response->getData());
                $response->reset();
            }
        }

        return $arrayResponse;
    }

    /**
     * @param $type
     * @param $id
     * @return $this
     */
    public function get($type, $id)
    {
        /** @var AbstractComponentManager $manager */
        $manager = $this->getManager($type);

        /** @var BaseResponse $response */
        $response = $manager->getResponse();

        $entity = $manager->get($id);

        if (!$entity) {
            $response->setError('Componente no encontrado.');
        }

        return $response->setData($entity);
    }

    /**
     * @param $type
     * @param $parameters
     * @return ArrayResponse
     */
    public function search($type, $parameters)
    {
        $arrayResponse = new ArrayResponse();

        /** @var AbstractComponentManager $manager */
        $manager = $this->getManager($type);

        /** @var BaseResponse $response */
        $response = $manager->getResponse();
        foreach ($manager->search($parameters) as $entity) {
            if (BaseResponse::SUCCESS === $response->setData($entity)->isSuccess()) {
                $arrayResponse->addItem($response->getData());
                $response->reset();
            }
        }

        return $arrayResponse;
    }
}
