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
    $resolver->replaceDefaults(array(
      'filter'   => 'admin_thumbnail'
    ));
  }

  public function buildView(FormView $view, FormInterface $form, array $options)
  {
    parent::buildView($view, $form, $options);
    $view->vars['filter'] = $options['filter'];
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