<?php
namespace Beaver\BackendBundle\Form;

use Beaver\CoreBundle\Model\Base\Statutory;
use Beaver\CoreBundle\Model\Interfaces\LayoutInterface;
use Beaver\CoreBundle\Service\LayoutService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PageFormType extends AbstractType
{
    /** @var LayoutService */
    private $layoutService;
    
    public function __construct(LayoutService $layoutService)
    {
        $this->layoutService = $layoutService;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($builder->getData()) {
            $builder
                ->add('id', HiddenType::class, [
                    'label' => false,
                    'attr'  => [
                        'type' => 'hidden'
                    ]
                ])
                ->add('published', ChoiceType::class, [
                    'label'     => 'Published',
                    'choices'   => [
                        'Published'     => Statutory::PUBLISHED,
                        'Unpublished'   => Statutory::UNPUBLISHED
                    ]
                ])
            ;
        }
    
        $builder
            ->add('name', TextType::class, [
                'label'     => 'Name',
                'required'  => true,
                'attr'      => [
                    'placeholder'           => 'Typping the page name',
                    'data-rule-required'    => 'true',
                    'data-msg-required'     => 'Este campo es requerido'
                ],
            ])
            ->add('slug', TextType::class, [
                'label'     => 'Slug',
                'required'  => true,
                'attr'      => [
                    'placeholder'            => 'Typping the slug for page',
                    'data-rule-required'    => 'true',
                    'data-msg-required'     => 'Este campo es requerido'
                ],
            ])
            ->add('layout', ChoiceType::class, [
                'label'         => 'Layout',
                'required'      => true,
                'placeholder'   => 'Choice a layout',
                'attr'          => [
                    'data-rule-required'    => 'true',
                    'data-msg-required'     => 'Seleccione una opción'
                ],
                'choices'       => $this->getChoices(),
            ])
            ->add('theme', TextType::class, [
                'attr'          => [
                    'data-rule-required'    => 'true',
                    'data-msg-required'     => 'Este campo es requerido'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr'  => [
                    'class' => 'button green'
                ]
            ])
        ;
    }

    /**
     * @return array
     */
    private function getChoices()
    {
        $layouts = array();
        
        /** @var LayoutInterface $layout */
        foreach ($this->layoutService->getLayouts() as $layout) {
            $layouts[$layout->getName()] = $layout->getCode();
        }
        
        return $layouts;
    }
}