<?php

namespace ChildBundle\Form;

use ShopBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('category', EntityType::class, [
                    'class' => 'ShopBundle\Entity\Category',
                    'query_builder' => function (CategoryRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where("u.type='Quiz'");
                    },
                    'choice_label' => 'name'
                ] )
                ->add('difficulty', ChoiceType::class, [
                    'choices' => [
                        'Très facile' => 1,
                        'Facile' => 2,
                        'Moyenne' => 3,
                        'Difficile' => 4,
                        'Pour les genies' => 5
                    ]
                ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChildBundle\Entity\Quiz'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'childbundle_quiz';
    }


}
