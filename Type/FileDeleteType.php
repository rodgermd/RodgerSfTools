<?php
/**
 * Created by PhpStorm.
 * User: rodger
 * Date: 12.05.14
 * Time: 17:10.
 */

namespace Rodgermd\SfToolsBundle\Type;

use Rodgermd\SfToolsBundle\DataTransformer\FileDeleteDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FileDeleteType.
 */
class FileDeleteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new FileDeleteDataTransformer());
        $builder
            ->add('delete', CheckboxType::class, array('required' => true))
            ->add('file', FileType::class, array('required' => @$options['required'], 'data_class' => 'Symfony\Component\HttpFoundation\File\File'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'file_delete';
    }
}
