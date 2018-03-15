<?php

namespace ParentingBundle\Form;

use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use MediaBundle\Form\PhotoType;
use ShopBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', FroalaEditorType::class)
            ->add('location')
            ->add('name')
            ->add('phone')
            ->add('lng')
            ->add('lat')
            ->add('image',PhotoType::class, [
                'required' => false
            ])
            ->add('category',EntityType::class, array(
                'class' => 'ShopBundle\Entity\Category',
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("u.type='Adresses'");},
                'choice_label' => 'name',

            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ParentingBundle\Entity\Address'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'parentingbundle_address';
    }


}
