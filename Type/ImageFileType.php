<?php

  namespace Rodgermd\SfToolsBundle\Type;

  use Symfony\Component\Form\Extension\Core\Type\FileType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\Form\FormView;
  use Symfony\Component\Form\FormInterface;
  use Symfony\Component\OptionsResolver\OptionsResolverInterface;

  class ImageFileType extends FileType
  {
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'method' => 'getFilename', 'filter' => 'small', 'use_delete' => false, 'data_class' => 'Symfony\Component\HttpFoundation\File\File'
      ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      parent::buildForm($builder, $options);
      $builder->setAttribute('method', $options['method']);
      $builder->setAttribute('filter', $options['filter']);
      $builder->setAttribute('use_delete', $options['use_delete']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
      $view->vars = array_replace($view->vars, array(
        'method'     => $form->getConfig()->getAttribute('method'),
        'filter'     => $form->getConfig()->getAttribute('filter'),
        'use_delete' => $form->getConfig()->getAttribute('use_delete'),
      ));
    }


    public function getParent()
    {
      return 'file';
    }

    public function getName()
    {
      return 'image_file';
    }
  }
