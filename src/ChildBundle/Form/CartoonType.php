<?php

namespace ChildBundle\Form;

use Doctrine\DBAL\Types\ArrayType;
use MediaBundle\Form\PhotoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartoonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('summary')
            ->add('episodesCnt')
            ->add('age', ChoiceType::class, [
                'choices' => [
                    '3 à 5 ans' => '1',
                    '6 à 8 ans' => '2',
                    '9 à 12 ans' => '3'
                ],
                'multiple' => false
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Fille' => '0',
                    'Garçon' => '1',
                    'Les deux' => '2'
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('photo', PhotoType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChildBundle\Entity\Cartoon'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'childbundle_cartoon';
    }


}
