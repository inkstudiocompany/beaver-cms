<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/2/17
 * Time: 22:56
 */
namespace Beaver\ContentBundle\Base\Contents;

use Beaver\ContentBundle\Base\Entity\ContentEntityInterface;
use Beaver\ContentBundle\Service\Response\ContentResponse;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;

/**
 * Class AbstractContentManager
 * @package Beaver\ContentBundle\Base
 */
abstract class AbstractContentManager
{
    /** @var ContentManagerInterface $manager */
    private static $manager = null;

    /** @var  EntityManager */
    protected $entityManager;

    /**
     * Component Manager must implement singleton pattern.
     *
     * @return self
     */
    static public function manager()
    {
	    return new static();
        if (!self::$manager) {
            self::$manager = new static();
        }
        return self::$manager;
    }
	
	/**
	 * Returns string as ID's content.
	 *
	 * @return mixed
	 */
	abstract static function Type();
	
	/**
	 * Returns the formtype for creation/edition of a content.
	 *
	 * @return mixed
	 */
	abstract public function FormType();
	
	/**
	 * Return a repository for the content.
	 *
	 * @return \Beaver\ContentBundle\Base\Entity\AbstractContentEntity
	 */
	abstract public function Repository();
	
	/**
	 * @return ContentResponse
	 */
	public function getResponse()
	{
		return new ContentResponse();
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
        if (false === $this->FormType()) {
            throw new \Exception('No se ha definido el form type para el contenido. Se espera que defina el atributo $formType');
        }
        return $formFactory->create($this->FormType(), $data, $options);
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
        return $this->entityManager->getRepository($this->Repository())->findAll();
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
            return $this->entityManager->getRepository($this->Repository())->find($id);
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
            $contentEntity = $this->entityManager->getRepository($this->Repository())->find($id);
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
    public function setEntityData(ContentEntityInterface $entity, $data = [])
    {
    	foreach ($data as $name => $value)
	    {
	    	if (method_exists($entity, 'set'.ucfirst(strtolower($name)))) {
			    $entity->{'set'.ucfirst(strtolower($name))}($value);
		    }
	    }
    }

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
            $repository = $this->Repository();
            
            if (true === isset($data['id'])) {
                $entity = $this->entityManager->getRepository($this->Repository())->find($data['id']);
            }
            if (false === isset($data['id'])) {
                $entity = new $repository;
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
}
