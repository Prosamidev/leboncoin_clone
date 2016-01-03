<?php

namespace leboncoinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class ImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array('label' => false, 'attr' => array('class' => 'input-image', "accept" => "image/*")));  

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'leboncoinBundle\Entity\Image',
        ));
    }

    public function getName()
    {
        return 'leboncoinbundle_imagetype';
    }
}