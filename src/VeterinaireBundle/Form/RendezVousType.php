<?php

namespace VeterinaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('num',NumberType::class)
            ->add('date',DateType::class,array(
                'widget'=>'single_text',
                'attr' => array(
                    'min' => date('Y-m-d')
                )
            ))
            ->add('heure',TimeType::class,array(
                'widget'=>'single_text'
            ))
            ->add('typea',TextType::class)

            ->add('photoa',FileType::class , array(
                'required' => false,
                'data_class'=>null,

            ))
;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VeterinaireBundle\Entity\RendezVous'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'veterinairebundle_rendezvous';
    }


}
