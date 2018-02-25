<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 19:56
 */

namespace Beaver\CoreBundle\Service;

use Beaver\BackendBundle\BackendBundle;
use Beaver\CoreBundle\Entity\Block;
use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Model\Interfaces\ModelInterface;
use Beaver\CoreBundle\Model\Page\Block as BlockModel;
use Beaver\CoreBundle\Model\Page\Area;
use Beaver\CoreBundle\Model\Page\Page;
use Beaver\CoreBundle\Response\ArrayResponse;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Response\BlockResponse;
use Beaver\CoreBundle\Response\BooleanResponse;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BlockService
 * @package Beaver\CoreBundle\Service
 *
 * Servicio para el manejo de páginas
 */
class BlockService extends WebComponentAbstractService
{
	/** @var EntityManager $em */
	protected $entityManager;

    /** @var  ContextService */
    protected $contextService;

    /** @var  ComponentService */
    protected $componentService;

    /** @var  WidgetService */
    protected $widgetService;
    
    /** @var string  */
    protected $projectDirectory = '';
    
    /** @var array $blocksDirectory */
    protected $blocksDirectory = array();

	public function __construct(
        EntityManager $entityManager,
        ContextService $contextService,
        ComponentService $componentService,
        WidgetService $widgetService,
		$projectDirectory,
		$blocksDirectory
    )
	{
		$this->entityManager    = $entityManager;
        $this->contextService   = $contextService;
        $this->componentService = $componentService;
        $this->widgetService    = $widgetService;
        $this->projectDirectory = $projectDirectory;
        $this->blocksDirectory  = $blocksDirectory;
	}

    /**
     * @return BlockResponse
     */
    function makeResponse()
    {
        return new BlockResponse();
    }
    
    /**
     * @return mixed
     */
    function getEntityComponent()
    {
        return Block::class;
    }
    
    /**
     * @param FormInterface $form
     * @return BlockResponse|mixed
     */
	public function save(FormInterface $form)
    {
    	$blockResponse = new BlockResponse();
        
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $blockResponse->setError('The form is not valid.');
        }
        
        try {
            $page   = (int) $form->get('page')->getData();
            $area   = $form->get('area')->getData();
            $view   = $form->get('block')->getData();

            $blockEntity = new Block();
            $blockEntity
                ->setPublished(Statutory::UNPUBLISHED)
                ->setPage($page)
                ->setArea($area)
	            ->setView('@' . $view)
                ->setOrder($this->getNextOrder($page, $area))
            ;
            
            $this->entityManager->persist($blockEntity);
            $this->entityManager->flush();
            
            if (BaseResponse::SUCCESS === $blockResponse->setData($blockEntity)->isSuccess()) {
                $this->setInfo($blockResponse->getData());
            }
        } catch (\Exception $exception) {
            $blockResponse->setError($exception->getMessage());
        }

        return $blockResponse;
    }
    
    /**
     * @param $block
     * @return BooleanResponse|mixed
     */
    public function delete($block)
    {
        $deleteResponse = new BooleanResponse();
    
        if (!$block) {
            return $deleteResponse->setError('Parámetros incorrectos');
        }
    
        try {
            $blockEntity = $this->entityManager->getRepository(Block::class)
                ->find($block)
            ;
        
            if (!$blockEntity) {
                return $deleteResponse->setError('No se encontró el block');
            }
            
            $this->entityManager->remove($blockEntity);
            $this->entityManager->flush();
            $this->orderRefresh($blockEntity->getPage(), $blockEntity->getArea());
        } catch (\Exception $exception) {
            $deleteResponse->setError($exception->getMessage());
        }
    
        return $deleteResponse;
    }
    
    /**
     * @param $idBlockToMove      id del bloque a mover.
     * @param $idBlockToReplace   id del bloque con la que intercambiará de lugar.
     * @return $this|mixed
     *
     * Mueve de lugar dos filas intercambiando sus lugares.
     */
    public function moveBlock($idBlockToMove, $idBlockToReplace)
    {
        $orderResponse = new BooleanResponse();
        
        try {
            $blockToMove    = $this->entityManager->getRepository(Block::class)->find($idBlockToMove);
            
            $blockToReplace = $this->entityManager->getRepository(Block::class)->find($idBlockToReplace);
            
            if (!$blockToMove || !$blockToReplace) {
                return $orderResponse->setError('No se encontraron los bloques especificados.');
            }
            
            $orderToMove    = $blockToReplace->getOrder();
            $orderToReplace = $blockToMove->getOrder();
            
            $blockToMove->setOrder($orderToMove);
            $blockToReplace->setOrder($orderToReplace);
            
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $orderResponse->setError($exception->getMessage());
        }
        
        return $orderResponse;
    }
    
    /**
     * @param $page
     * @param $area
     * @return int
     */
    private function getNextOrder($page, $area)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
    
        $queryBuilder
            ->select('Max(B.order)')
            ->from(Block::class, 'B')
            ->where('B.page = :page')
            ->andWhere('B.area = :area')
        ;
        
        $maxOrder = $queryBuilder->setParameter('page', $page)
            ->setParameter('area', $area)
            ->getQuery()
            ->getResult()
        ;
        
        if (!$maxOrder) {
            return 1;
        }
    
        return ((int) $maxOrder[0][1]) + 1;
    }
    
    /**
     * @param $page
     * @param $area
     * @return BooleanResponse
     */
    public function orderRefresh($page, $area)
    {
        $orderResponse = new BooleanResponse();
        
        try {
            $blockArrayEntity = $this->entityManager->getRepository(Block::class)
                ->findBy([
                    'page'  => $page,
                    'area'  => $area,
                ], [
                    'order' => 'ASC',
                ])
            ;
            
            /** @var Block $block */
            foreach ($blockArrayEntity as $key => $block) {
                $block->setOrder($key + 1);
            }
            
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $orderResponse->setError($exception->getMessage());
        }
        
        return $orderResponse;
    }

    /**
     * Set all blocks definied in the page.
     *
     * @param Page $page
     * @throws \Exception
     */
    public function setComponents($page)
    {
        /** @var Area $area */
        foreach ($page->getLayout()->getAreas() as $area) {
            $condition = [
                'page'      => $page->getId(),
                'area'      => $area->getName(),
                'published' => Statutory::PUBLISHED
            ];
            if (BackendBundle::BUNDLE === $this->contextService->getBundle()) {
                unset($condition['published']);
            }

            $blockArrayEntity = $this->entityManager->getRepository(Block::class)
                ->findBy($condition, ['order' => 'ASC'])
            ;

            if ($blockArrayEntity) {
                $blockResponse = new BlockResponse();
                /** @var Block $block */
                foreach ($blockArrayEntity as $block) {
                    if (BaseResponse::SUCCESS === $blockResponse->setData($block)->isSuccess()) {
                        $this->setInfo($blockResponse->getData());
                        $area->addBlock($blockResponse->getData());
                        $blockResponse->reset();
                    }
                }
            }
        }
    }

    /**
     * @param $block
     * @return BlockResponse|mixed
     */
    public function get($block)
    {
        $blockResponse = new BlockResponse();

        if (!$block) {
            return $blockResponse->setError('Parámetros incorrectos');
        }

        try {
            $blockEntity = $this->entityManager->getRepository(Block::class)
                ->find($block)
            ;

            if (!$blockEntity) {
                return $blockResponse->setError('No se encontró el block');
            }

            if (BaseResponse::SUCCESS === $blockResponse->setData($blockEntity)->isSuccess()) {
                $this->setInfo($blockResponse->getData());
            }

        } catch (\Exception $exception) {
            $blockResponse->setError($exception->getMessage());
        }

        return $blockResponse;
    }

    /**
     * @param ModelInterface $component
     * @return ModelInterface
     * @throws \Exception
     */
    public function setInfo(ModelInterface $component)
    {
        if (false === $component instanceof BlockModel) {
            throw new \Exception('Se esperaba una instancia de Beaver\CoreBundle\Model\PageComponent\Block');
        }
	
        return $component;
    }

    /**
     * @return ArrayResponse
     */
	public function blocks()
	{
		$blocksResponse = new ArrayResponse();
		
		try {
			foreach ($this->blocksDirectory as $block) {
				$blocksResponse->addItem($block);
			}
		} catch (\Exception $exception) {
			$blocksResponse->setError($exception->getMessage());
		}
		
		return $blocksResponse;
	}
}
