<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rodger
 * Date: 28.04.13
 * Time: 22:40
 * To change this template use File | Settings | File Templates.
 */

namespace Rodgermd\SfToolsBundle\Type;


use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageType
 * Defines Image form type
 *
 * @package Rodgermd\SfToolsBundle\Type
 */
class ImageType Extends FileType
{
    /**
     * Sets default options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->replaceDefaults(
            array(
                'filter'          => 'admin_thumbnail',
                'object_property' => null,
                'preview'         => null,
                'required'        => false
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
        parent::buildView($view, $form, $options);
        $view->vars['filter']  = $options['filter'];
        $view->vars['object']  = $form->getParent()->getData();
        $view->vars['preview'] = $options['preview'];
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return 'image';
    }

    /**
     * Gets parent form
     *
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'file';
    }
}