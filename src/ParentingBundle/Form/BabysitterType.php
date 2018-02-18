<?php

namespace ParentingBundle\Form;

use MediaBundle\Form\PhotoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BabysitterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('state',ChoiceType::class, array(
                'choices' => array(
                    'Occupée' => 'Occupée',
                    'Libre' => 'Libre',

                )))

            ->add('address',ChoiceType::class, array(
                'choices' => array(
                    'Ariana' => 'Ariana',
                    'Ben Arous' => 'Ben Arous',
                    'Manouba' => 'Manouba',
                    'Bardo' => 'Bardo',
                )))
            ->add('price')
            ->add('image',PhotoType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ParentingBundle\Entity\Babysitter'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'parentingbundle_babysitter';
    }


}
