<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/18/17
 * Time: 08:57
 */
namespace Beaver\CoreBundle\Widgets\Dummy;

use Beaver\ContentBundle\Contents\Dummy\DummyResponse;
use Beaver\ContentBundle\Entity\Dummy;
use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Widgets\WidgetInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class BannerWidget
 * @package Beaver\CoreBundle\Widgets\Banner
 */
class DummyWidget implements WidgetInterface
{
    /** @var  EntityManager */
    private $entityManager;

    /**
     * DummyWidget constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getName()
    {
        return 'Dummy';
    }

    public function getDescription()
    {
        return 'Aqui podemos poner cualquier descripcion para el objeto';
    }

    public function getView()
    {
        return '@BeaverCore/Widget/banner.html.twig';
    }

    /**
     * @return array
     */
    public function getData()
    {
        $dummyResponse = $this->lastDummy();
        if ($dummyResponse->isEmpty()) {
            return [];
        }
        return $dummyResponse->getData()->toArray();
    }

    /**
     * @return $this|array
     */
    public function lastDummy()
    {
        $dummyResponse = new DummyResponse();
        try {
            /** @var Dummy $dummy */
            $dummy = $this->entityManager->getRepository(Dummy::class)
                ->findOneBy(['published' => Statutory::PUBLISHED], ['id' => 'DESC'], 1);

            if (!$dummy) {
                return $dummyResponse;
            }
        } catch (\Exception $exception) {

        }

        return $dummyResponse->setData($dummy);
    }
}