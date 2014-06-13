<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 12.05.14
 * Time: 17:10
 */

namespace Rodgermd\SfToolsBundle\Type;


use Rodgermd\SfToolsBundle\DataTransformer\FileDeleteDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileDeleteType
 *
 * @package Rodgermd\SfToolsBundle\Type
 */
class FileDeleteType extends AbstractType
{
    /**
     * Defines form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new FileDeleteDataTransformer());
        $builder
            ->add('delete', 'checkbox', array('required' => true))
            ->add('file', 'file', array('required' => @$options['required'], 'data_class' => 'Symfony\Component\HttpFoundation\File\File'));
    }

    /**
     * Sets default options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->replaceDefaults(
            array('required' => false)
        );
    }

    /**
     * Form name
     *
     * @return string
     */
    public function getName()
    {
        return 'file_delete';
    }
} 