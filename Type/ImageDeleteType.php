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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ImageDeleteType
 * Image with delete option form type.
 */
class ImageDeleteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new FileDeleteDataTransformer());
        $builder
            ->add('delete', CheckboxType::class, array('required' => true))
            ->add(
                'file',
                ImageType::class,
                array(
                    'required' => @$options['required'],
                    'filter' => @$options['filter'],
                    'data_class' => File::class,
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['object'] = $view->parent->vars['data'];
        $view->vars['delete_label'] = $options['delete_label'];
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->children['file']->vars['object'] = $form->getParent()->getData();
        $view->children['file']->vars['object_property'] = $view->vars['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'filter' => 'admin_thumbnail',
                'delete_label' => null,
                'required' => false,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'image_delete';
    }
}
