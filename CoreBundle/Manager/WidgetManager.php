<?php
namespace Beaver\CoreBundle\Manager;

use Beaver\CoreBundle\Entity\WidgetTemplate;
use Beaver\CoreBundle\Manager\Base\AbstractComponentManager;
use Beaver\CoreBundle\Response\WidgetTemplateResponse;
use Doctrine\ORM\Query\ResultSetMapping;

class WidgetManager extends AbstractComponentManager
{
    static function manager()
    {
        if (null === self::$manager || false === self::$manager instanceof self) {
            self::$manager = new self();
        }
        return self::$manager;
    }

    public function getResponse()
    {
        return new WidgetTemplateResponse();
    }

    public function getEntity()
    {
        return WidgetTemplate::class;
    }

    /**
     * This method performs a search by applying the filters specified in the parameters.
     *
     * @param $parameters
     * @return mixed
     */
    public function search($parameters)
    {
        $size = (isset($parameters['size'])) ? $parameters['size'] : 0;

        $resultMapping = new ResultSetMapping();
        $resultMapping
            ->addEntityResult(WidgetTemplate::class, 'w')
            ->addFieldResult('w', 'id', 'id')
            ->addFieldResult('w', 'name', 'name')
            ->addFieldResult('w', 'description', 'description')
            ->addFieldResult('w', 'view', 'view')
            ->addFieldResult('w', 'content_type', 'contentType')
            ->addFieldResult('w', 'type', 'type')
        ;

        $query = $this->entityManager
            ->createNativeQuery('SELECT * FROM widget_template JOIN widget_size 
            ON widget_template.id = widget_size.widget_id WHERE widget_size.size = :size', $resultMapping);

        $query->setParameter('size', $size);

        return $query->getResult();
    }
}
