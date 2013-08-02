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

class ImageType Extends FileType
{
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    parent::setDefaultOptions($resolver);
    $resolver->replaceDefaults(array(
      'filter'          => 'admin_thumbnail',
      'object_property' => null,
      'preview'         => null
    ));
  }

  public function buildView(FormView $view, FormInterface $form, array $options)
  {
    parent::buildView($view, $form, $options);
    $view->vars['filter']  = $options['filter'];
    $view->vars['object']  = $form->getParent()->getData();
    $view->vars['preview'] = $options['preview'];
  }

  public function getName()
  {
    return 'image';
  }

  public function getParent()
  {
    return 'file';
  }
}