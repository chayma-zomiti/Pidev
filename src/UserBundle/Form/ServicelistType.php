<?php

namespace UserBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicelistType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description',TextareaType::class,array('attr' => array('class' => 'form-control required')))
            ->add('animaltype',TextType::class,array('attr' => array('class' => 'form-control required')))
            ->add('datedebut',DateType::class,array('attr' => array('class' => 'required')))
            ->add('datefin',DateType::class,array('attr' => array('class' => 'required')))
            ->add('phonenumber',NumberType::class,array('attr' => array('class' => 'form-control required')))
            ->add('servicetype',TextType::class,array('attr' => array('class' => 'form-control required')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Servicelist'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_servicelist';
    }


}
