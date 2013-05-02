<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rodger
 * Date: 28.04.13
 * Time: 23:17
 * To change this template use File | Settings | File Templates.
 */

namespace Rodgermd\SfToolsBundle\Type;


use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class RichTextType extends TextareaType
{
  public function getParent()
  {
    return 'textarea';
  }

  public function getName()
  {
    return 'rich_text';
  }

  public function buildView(FormView $view, FormInterface $form, array $options)
  {
    parent::buildView($view, $form, $options);
    $view->vars['attr']['class'] = trim((@$view->vars['attr']['class']) . ' rich-field');
  }
}