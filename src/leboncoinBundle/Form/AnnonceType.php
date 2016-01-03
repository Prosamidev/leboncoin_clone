<?php
namespace leboncoinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use leboncoinBundle\Form\ImageType;

class AnnonceType extends AbstractType
{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder->add('titre','text');
        $builder->add('description','text');       
        $builder->add('prix','integer');
        $builder->add('images','collection', array(
            'type'=> new ImageType(),
            'prototype'=>true,
            'allow_add'=>true,
            'allow_delete'=>true,
            'by_reference'=>false,
            'options'  => array(
                'required'  => true,
                'label' => false,
                'attr'      => array('class' => 'input-image'),
        )));
        
    }

     public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'leboncoinBundle\Entity\Annonce'
        ));
    }

    public function getName()
    {
        return 'leboncoinbundle_annoncetype';
    }

}
?>