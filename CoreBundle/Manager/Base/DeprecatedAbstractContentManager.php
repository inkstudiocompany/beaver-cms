<?php
namespace Beaver\CoreBundle\Manager\Base;

use Beaver\CoreBundle\Manager\Interfaces\ContentManagerInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractContentManager
 * @package Beaver\CoreBundle\Manager\Base
 */
abstract class AbstractContentManager implements ContentManagerInterface
{
    const NO_PARAMETERS     = 'Incorrect parameters.';
    const NO_VALID          = 'Invalid data.';

    /** @var ContentManagerInterface $manager */
    protected static $manager = null;

    /** @var  EntityManager $entityManager */
    protected $entityManager;

    /**
     * AbstractContentManager constructor.
     */
    public function __construct() {
    }

    /**
     * Component Manager must implement singleton pattern.
     *
     * @return self
     */
    static public function manager()
    {
        if (!self::$manager) {
            self::$manager = new static();
        }
        return self::$manager;
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
}
