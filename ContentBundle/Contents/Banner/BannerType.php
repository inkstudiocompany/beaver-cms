<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 10/7/17
 * Time: 18:14
 */

namespace Beaver\ContentBundle\Contents\Banner;

use Beaver\ContentBundle\Base\Form\AbstractContentType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class BannerType
 * @package Beaver\ContentBundle\Banner
 */
class BannerType extends AbstractContentType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    protected function buildContentForm(FormBuilderInterface $builder, array $options)
    {
        if (true === isset($options['data']['id'])) {
            $builder->add('id', HiddenType::class);
        }

        $builder
            ->add('name', TextType::class)
            ->add('text', TextareaType::class, [
                'label' => false,
                'attr'  => [

                    'class' => 'editor'
                ]
            ])
        ;
    }

    /**
     * @return string
     */
    protected function getType()
    {
        return strtolower(Banner::TYPE);
    }
}
