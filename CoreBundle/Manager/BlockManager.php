<?php
namespace Beaver\CoreBundle\Manager;

use Beaver\CoreBundle\Entity\BlockTemplate;
use Beaver\CoreBundle\Manager\Base\AbstractComponentManager;
use Beaver\CoreBundle\Response\BlockTemplateResponse;

class BlockManager extends AbstractComponentManager
{
    static function manager()
    {
        if (null === self::$manager || false === self::$manager instanceof self) {
            self::$manager = new self();
        }
        return self::$manager;
    }

    public function getEntity()
    {
        return BlockTemplate::class;
    }

    public function getResponse()
    {
        return new BlockTemplateResponse();
    }

    /**
     * This method performs a search by applying the filters specified in the parameters.
     *
     * @param $parameters
     * @return mixed
     */
    public function search($parameters)
    {
        // TODO: Implement search() method.
    }

    public function save($parameters)
    {
        // TODO: Implement save() method.
    }
}
