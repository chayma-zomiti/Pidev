<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use UserBundle\Entity\Categorie;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('libelleproduit',TextType::class,array('attr' => array('class' => 'form-control required')))
            ->add('descriptionproduit',TextareaType::class,array('attr' => array('class' => 'form-control required','rows'=>5)))
            ->add('etatproduit',TextType::class,array('attr' => array('class' => 'form-control required')))
            ->add('prixproduit',NumberType::class,array('attr' => array('class' => 'form-control required')))
            ->add('idcategorie',EntityType::class,
                array(
                    'class' => 'UserBundle\Entity\Categorie',
                    'choice_value' =>'idcategorie',
                    'choice_label' => 'nomcategorie',
                    'attr'=>['class'=>'select2_single form-control '],
                    'multiple' => false,
                )
            )
            ->add('file')
            //->add('imageproduit',TextType::class,array('attr' => array('class' => 'form-control required')))
            ->add('stock',NumberType::class,array('attr' => array('class' => 'form-control required')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_produit';
    }


}
