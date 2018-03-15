<?php

namespace ParentingBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use MediaBundle\Form\PhotoType;
use ShopBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('title')
            ->add('content', FroalaEditorType::class)
            ->add('src')
            ->add('subject')
            ->add('auteur')
            ->add('category',EntityType::class, array(
                'class' => 'ShopBundle\Entity\Category',
                'query_builder' => function (CategoryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                       ->where("c.type='Articles'");
                },
                'choice_label' => 'name',

            ))
            ->add('date')
            ->add('image',PhotoType::class, [
                'attr' => [
                    'required' => false
                ]
            ])
        ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ParentingBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'parentingbundle_article';
    }


}
