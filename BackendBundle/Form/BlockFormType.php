<?php
namespace Beaver\BackendBundle\Form;

use Beaver\CoreBundle\Model\Configuration\BlockTemplate;
use Beaver\CoreBundle\Response\BaseResponse;
use Beaver\CoreBundle\Service\BlockService;
use Beaver\CoreBundle\Service\ComponentService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class BlockFormType extends AbstractType
{
    /** @var ComponentService */
    private $componentsService;
    
    /** @var BlockService */
    private $blocksService;

    /**
     * BlockFormType constructor.
     *
     * @param BlockService $blockService
     */
    public function __construct(BlockService $blockService)
    {
        $this->blocksService = $blockService;
    }
	
	/**
	 * @param \Symfony\Component\Form\FormBuilderInterface $builder
	 * @param array                                        $options
	 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page', HiddenType::class)
            ->add('area', HiddenType::class)
            ->add('block', ChoiceType::class, [
                'label'         => 'Block layout',
                'required'      => true,
                'placeholder'   => 'Choice a block layout',
                'attr'          => [
                    'data-rule-required'    => 'true',
                    'data-msg-required'     => 'Seleccione una opción'
                ],
                'choices'       => $this->getChoices(),
            ])
            ->add('submit', SubmitType::class)
        ;
    }
    
    /**
     * @return array|mixed
     */
    private function getChoices()
    {
        $choices = array();
        
        $blocksResponse = $this->blocksService->blocks();
        if (BaseResponse::SUCCESS === $blocksResponse->isSuccess()) {
	        foreach ($blocksResponse->getData() as $block) {
		        $choices[$block['name']] = $block['twig'];
	        }
        }
        
        return $choices;
    }
}
