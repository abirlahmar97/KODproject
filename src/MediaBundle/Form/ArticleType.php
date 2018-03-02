<?php

namespace MediaBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\Mapping\Entity;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
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

            ->add('description')
            ->add('src')
            ->add('title')
            ->add('subject')
            ->add('auteur')
            ->add('type',ChoiceType::class, array(
                'choices' => array(
                    'Aides et services' => 'Aides et services',
                    'Education' => 'Education',

                )))
            ->add('category',EntityType::class, array(
                'class' => 'ShopBundle\Entity\Category',
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('u')
                       ->where("u.type='Article'");},
                'choice_label' => 'name',

            ))
            ->add('date')
            ->add('image',PhotoType::class)
        ;
        $builder->add( "description", FroalaEditorType::class);


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MediaBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mediabundle_article';
    }


}
