<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rodger
 * Date: 28.04.13
 * Time: 22:40
 * To change this template use File | Settings | File Templates.
 */

namespace Rodgermd\SfToolsBundle\Type;


use Rodgermd\SfToolsBundle\DataTransformer\ImageDeleteDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageDeleteType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->addViewTransformer(new ImageDeleteDataTransformer());
    $builder
      ->add('delete', 'checkbox', array('required' => true))
      ->add('file', 'image', array(
        'required'   => @$options['required'],
        'filter'     => @$options['filter'],
        'data_class' => 'Symfony\Component\HttpFoundation\File\File'));
  }

  public function buildView(FormView $view, FormInterface $form, array $options)
  {
    $view->vars['object']                   = $view->parent->vars['data'];
  }

  public function finishView(FormView $view, FormInterface $form, array $options)
  {
    $view->children['file']->vars['object'] = $form->getParent()->getData();
    $view->children['file']->vars['object_property'] = $view->vars['name'];

  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->replaceDefaults(array(
      'filter' => 'admin_thumbnail',
    ));
  }


  public function getName()
  {
    return 'image_delete';
  }
}