<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 13.06.14
 * Time: 12:44
 */

namespace Rodgermd\SfToolsBundle\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileDownloadType
 *
 * @package Rodgermd\SfToolsBundle\Type
 */
class FileDownloadType extends AbstractType
{
    /**
     * Prepares view
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['url_prefix'] = $options['url_prefix'];
    }

    /**
     * Sets default options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->replaceDefaults(
            array(
                'data_class' => 'Symfony\Component\HttpFoundation\File\File',
                'url_prefix' => null
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'file_download';
    }

    /**
     * Form parent
     *
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'file';
    }
}