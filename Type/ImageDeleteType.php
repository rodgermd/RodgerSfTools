<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rodger
 * Date: 28.04.13
 * Time: 22:40
 * To change this template use File | Settings | File Templates.
 */

namespace Rodgermd\SfToolsBundle\Type;


use Rodgermd\SfToolsBundle\DataTransformer\FileDeleteDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageDeleteType
 * Image with delete option form type
 *
 * @package Rodgermd\SfToolsBundle\Type
 */
class ImageDeleteType extends AbstractType
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
            ->add(
                'file',
                'image',
                array(
                    'required'   => @$options['required'],
                    'filter'     => @$options['filter'],
                    'data_class' => 'Symfony\Component\HttpFoundation\File\File'
                )
            );
    }

    /**
     * Builds view
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['object']       = $view->parent->vars['data'];
        $view->vars['delete_label'] = $options['delete_label'];
    }

    /**
     * Finish view
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->children['file']->vars['object']          = $form->getParent()->getData();
        $view->children['file']->vars['object_property'] = $view->vars['name'];
    }

    /**
     * Sets default options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'filter'       => 'admin_thumbnail',
                'delete_label' => null,
                'required'     => false
            )
        );
    }

    /**
     * Form name
     *
     * @return string
     */
    public function getName()
    {
        return 'image_delete';
    }
}