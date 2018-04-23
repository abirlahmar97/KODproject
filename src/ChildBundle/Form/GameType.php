<?php

namespace ChildBundle\Form;

use Doctrine\DBAL\Types\ArrayType;
use MediaBundle\Form\PhotoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('url')
            ->add('age', ChoiceType::class, [
                'choices' => [
                    '3 à 5 ans' => '1',
                    '6 à 8 ans' => '2',
                    '9 à 12 ans' => '3'
                ],
                'multiple' => false
            ])
            ->add('devices', ChoiceType::class, [
                'choices' => [
                    'Smartphone' => '1',
                    'Tablette' => '2',
                    'Pc' => '3'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('icon', PhotoType::class, [
                'required' => false
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChildBundle\Entity\Game'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'childbundle_game';
    }


}
