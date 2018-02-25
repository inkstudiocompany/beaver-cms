<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/2/17
 * Time: 22:56
 */
namespace Beaver\ContentBundle\Base\Contents;

use Beaver\ContentBundle\Base\Entity\ContentEntityInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormFactory;

/**
 * Class AbstractContentManager
 * @package Beaver\ContentBundle\Base
 */
abstract class AbstractContentManager
{
    /** @var ContentManagerInterface $manager */
    protected static $manager = null;

    /** @var  string */
    protected $repository = false;

    /** @var  string */
    protected $formType = false;

    /** @var  EntityManager */
    protected $entityManager;

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
        /** @var EntityManager entityManager */
        $this->entityManager    = $entityManager;
        return $this;
    }
	
	/**
	 * @param \Symfony\Component\Form\FormFactory $formFactory
	 * @param null                                $data
	 * @param array                               $options
	 *
	 * @return \Symfony\Component\Form\FormInterface
	 * @throws \Exception
	 */
    public function form(FormFactory $formFactory, $data = null, array $options = array())
    {
        if (false === $this->formType) {
            throw new \Exception('No se ha definido el form type para el contenido. Se espera que defina el atributo $formType');
        }
        return $formFactory->create($this->formType, $data, $options);
    }

    /**
     * @return string
     */
    public function formView()
    {
        return '@Backend/Forms/content.html.twig';
    }


    /**
     * @param int $page
     * @return Collection
     */
    public function list($page = 1)
    {
        return $this->entityManager->getRepository($this->repository)->findAll();
    }
	
	/**
	 * @param $id
	 *
	 * @return null|object
	 * @throws \Exception
	 */
    public function get($id)
    {
        try {
            return $this->entityManager->getRepository($this->repository)->find($id);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        try {
            $contentEntity = $this->entityManager->getRepository($this->repository)->find($id);
            $this->entityManager->remove($contentEntity);
            $this->entityManager->flush();
            $this->entityManager->close();
        } catch (\Exception $exception) {
            throw $exception;
        }

        return true;
    }

    /**
     * @param $parameters
     * @return mixed
     */
    abstract public function search($parameters);

    /**
     * @param ContentEntityInterface $entity
     * @param array $data
     * @return mixed
     */
    abstract public function setEntityData(ContentEntityInterface $entity, $data = []);

    /**
     * @param array $data
     * @return ContentEntityInterface|bool
     * @throws \Exception
     */
    public function save($data = [])
    {
        try {
            /** @var ContentEntityInterface $entity */
            $entity = false;
            if (true === isset($data['id'])) {
                $entity = $this->entityManager->getRepository($this->repository)->find($data['id']);
            }
            if (false === isset($data['id'])) {
                $entity = new $this->repository;
            }

            $this->setEntityData($entity, $data);

            $entity->setPublished($data['published']);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            $this->entityManager->close();
        } catch (\Exception $exception) {
            throw $exception;
        }

        return $entity;
    }

    /** @return string */
    static function Type();
	
	/**
	 * @return \Beaver\CoreBundle\Response\BaseResponse
	 */
	public function getResponse();
}
