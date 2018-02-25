<?php
namespace Beaver\BackendBundle\Form;

use Beaver\CoreBundle\Model\Configuration\Widget;
use Beaver\CoreBundle\Service\ComponentService;
use Beaver\CoreBundle\Service\WidgetService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class WidgetFormType extends AbstractType
{
    /** @var WidgetService */
    private $widgetService;
    
    public function __construct(WidgetService $widgetService)
    {
        $this->widgetService = $widgetService;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $size = (isset($options['data']['size'])) ? $options['data']['size'] : 0;
        $builder
            ->add('block', HiddenType::class)
            ->add('size', HiddenType::class)
            ->add('slot', HiddenType::class)
            ->add('widget', ChoiceType::class, [
                'label'         => 'Widget',
                'required'      => true,
                'placeholder'   => 'Choice a widget',
                'attr'          => [
                    'data-rule-required'    => 'true',
                    'data-msg-required'     => 'Seleccione una opción'
                ],
                'choices'       => $this->getChoices($size),
            ])
            ->add('submit', SubmitType::class)
        ;
    }
    
    /**
     * @return array|mixed
     */
    private function getChoices($size)
    {
        $choices = array();
        $parameters = ['size' => $size];

        /** @var Widget $option */
        foreach ($this->widgetService->widgets() as $option){
            $choices[$option['name']] = $option['id'];
        }
        return $choices;
    }
}