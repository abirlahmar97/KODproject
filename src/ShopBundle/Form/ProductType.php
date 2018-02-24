<?php

namespace ShopBundle\Form;

use Doctrine\ORM\QueryBuilder;
use MediaBundle\Form\PhotoType;
use ShopBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('description')
            ->add('price')
            ->add('available')
            ->add('category',EntityType::class, array(
                'class' => 'ShopBundle\Entity\Category',
                'query_builder' => function(CategoryRepository $r){
                    $qb = $r->createQueryBuilder('c')
                        ->where("c.type = 'Produits'");
                    return $qb;
                },
                'choice_label' => 'name',
                'multiple' => false
            ))
            ->add('img', PhotoType::class)
            ->add('tva')
            ->add('gender',ChoiceType::class,array('choices' =>array(
                'Garçon' => 'Garçon',
                'fille' => 'fille',
            )))
            ->add('age');

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ShopBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shopbundle_product';
    }


}
