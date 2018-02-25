<?php
namespace Beaver\CoreBundle\Manager\Base;

use Beaver\CoreBundle\Manager\Interfaces\ComponentManagerInterface;
use Doctrine\ORM\EntityManager;

abstract class AbstractComponentManager implements ComponentManagerInterface
{
    const NO_PARAMETERS     = 'Incorrect parameters.';
    const NO_VALID          = 'Invalid data.';

    /** @var ComponentManagerInterface $manager */
    protected static $manager = null;

    /** @var EntityManager $entityManager */
    protected $entityManager = null;

    public function __construct() {
    }

    /**
     * @param EntityManager $entityManager
     * @return $this
     */
    public function setServices(EntityManager $entityManager)
    {
        $this->entityManager    = $entityManager;
        return $this;
    }

    /**
     * @return array
     */
    public function list()
    {
        return $this->entityManager->getRepository($this->getEntity())->findAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->entityManager->getRepository($this->getEntity())->find($id);
    }
}
