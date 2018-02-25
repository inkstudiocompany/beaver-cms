<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 2/11/17
 * Time: 19:56
 */

namespace Beaver\CoreBundle\Service;

use Beaver\CoreBundle\Model\Interfaces\ModelInterface;
use Beaver\CoreBundle\Model\Page\AbstractComponent;
use Beaver\CoreBundle\Model\Page\Block as BlockComponent;
use Beaver\CoreBundle\Entity\Widget;
use Beaver\CoreBundle\Model\Page\Block;
use Beaver\CoreBundle\Model\Page\Widget as WidgetModel;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Response\BooleanResponse;
use Beaver\CoreBundle\Response\WidgetResponse;
use Beaver\CoreBundle\Widgets\WidgetInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class WidgetService
 * @package Beaver\CoreBundle\Service
 *
 * Servicio para el manejo de widgets.
 */
class WidgetService extends WebComponentAbstractService
{
	/** @var EntityManager $em */
	protected $entityManager;

    /** @var  ContextService */
    protected $contextService;

    /** @var  ComponentService */
    protected $componentService;

    /**
     * @var array
     */
    private $widgets = [];

	public function __construct(
        EntityManager $entityManager,
        ContextService $contextService,
        ComponentService $componentService
    )
	{
		$this->entityManager    = $entityManager;
        $this->contextService   = $contextService;
        $this->componentService = $componentService;
	}

	public function addWidget($id, $widget)
    {
        $this->widgets[$id] = [
            'id'        => $id,
            'name'      => $widget->getName(),
            'widget'    => $widget,
        ];
    }

    public function widgets()
    {
        return $this->widgets;
    }
    
    /**
     * @return ResponseInterface
     */
    function makeResponse()
    {
        return new WidgetResponse();
    }
    
    /**
     * @return mixed
     */
    function getEntityComponent()
    {
        return Widget::class;
    }

    /**
     * @param FormInterface $form
     * @return WidgetResponse|mixed
     */
	public function save(FormInterface $form)
    {
        $widgetResponse = new WidgetResponse();
        
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $widgetResponse->setError('Form data is not valid.');
        }
        
        try {
            $block  = (int) $form->get('block')->getData();
            $slot   = $form->get('slot')->getData();
            $widget = $form->get('widget')->getData();

            $widgetEntity = new Widget();

            $widgetEntity
                ->setBlock($block)
                ->setSlot($slot)
                ->setWidget($widget)
            ;

            $this->entityManager->persist($widgetEntity);
            $this->entityManager->flush();

            $widgetResponse->setData($widgetEntity);

        } catch (\Exception $exception) {
            $widgetResponse->setError($exception->getMessage());
        }

        return $widgetResponse;
    }
    
    /**
     * @param $block
     * @return BooleanResponse|mixed
     */
    public function delete($widget)
    {
        $deleteResponse = new BooleanResponse();
    
        if (!$widget) {
            return $deleteResponse->setError('Parámetros incorrectos');
        }
    
        try {
            $widgetEntity = $this->entityManager->getRepository(Widget::class)
                ->find($widget)
            ;
        
            if (!$widgetEntity) {
                return $deleteResponse->setError('No se encontró el widget');
            }
            
            $this->entityManager->remove($widgetEntity);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            $deleteResponse->setError($exception->getMessage());
        }
    
        return $deleteResponse;
    }
    
    /**
     * @param BlockComponent $block
     * @throws \Exception
     */
    public function setComponents(BlockComponent $block)
    {
        if (false === $block instanceof BlockComponent) {
            throw new \Exception('Expected a instance of Beaver/CoreBundle/Model/PageComponents/Block');
        }

        $widgetsArrayEntities = $this->entityManager->getRepository(Widget::class)
            ->findBy(['block'   => $block->getId()]);

        if ($widgetsArrayEntities) {
            $widgetResponse = new WidgetResponse();

            /** @var Widget $instance */
            foreach ($widgetsArrayEntities as $instance) {
                if (BaseResponse::SUCCESS === $widgetResponse->setData($instance)->isSuccess()) {
                    if (true === $this->widgetPrepare($widgetResponse->getData())) {
                        $block->addWidget($widgetResponse->getData());
                    }
                }
                $widgetResponse->reset();
            }
        }
    }

    public function widgetPrepare(\Beaver\CoreBundle\Model\Page\Widget $widget)
    {
        /** @var WidgetInterface $service */
        if ($service = $this->get($widget->getWidget())) {
            $widget->setView($service->getView())->setData($service->getData());
            return true;
        }
        return false;
    }

    public function get($widgetService) {
        if (false === isset($this->widgets[$widgetService])) {
            return false;
        }
        return $this->widgets[$widgetService]['widget'];
    }

    /**
     * @deprecated
     * @param WidgetModel $component
     * @return AbstractComponent
     * @throws \Exception
     */
    public function setInfo(ModelInterface $component)
    {
        if (false === $component instanceof WidgetModel) {
            throw new \Exception('Se esperaba una instancia de Beaver\CoreBundle\Model\PageComponent\Widget');
        }

        if (false === $component->get instanceof \Beaver\CoreBundle\Model\Configuration\BlockTemplate) {
            $blockTemplateResponse = $this->componentService->get(ComponentService::BLOCKS, $component->getBlockTemplate());

            if (BaseResponse::FAIL === $blockTemplateResponse->isSuccess()) {
                throw new \Exception($blockTemplateResponse->getError());
            }
            $component->setBlockTemplate($blockTemplateResponse->getData());
        }

        return $component;
    }
}
