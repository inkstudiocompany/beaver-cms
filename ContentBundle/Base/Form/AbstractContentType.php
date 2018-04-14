<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/7/17
 * Time: 18:10
 */
namespace Beaver\ContentBundle\Base\Form;

use Beaver\ContentBundle\Base\Contents\AbstractContentManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class AbstractContentType
 * @package Beaver\ContentBundle\Form
 */
abstract class AbstractContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return mixed
     */
    abstract protected function buildContentForm(FormBuilderInterface $builder, array $options);

    /**
     * @return string
     */
    abstract protected function getType();

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contentType', HiddenType::class, [
                'label' => false,
                'data'  => strtolower($this->getType())
            ])
        ;
        $builder
            ->add('published', ChoiceType::class, [
                'data'          => false,
                'choices'       => array(
                    'Publicado'     => true,
                    'No publicado'  => false
                ),
            ])
        ;
        $this->buildContentForm($builder, $options);
        $builder
            ->add('cancel', ButtonType::class, [
                'attr' => [
                    'class'     => 'btn btn-outline-secondary',
	                'onclick'   => 'history.back()'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success'
                ]
            ])
        ;
    }
}
