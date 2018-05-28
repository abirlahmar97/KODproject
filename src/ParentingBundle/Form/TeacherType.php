<?php

namespace ParentingBundle\Form;

use MediaBundle\Form\PhotoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TeacherType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('subject', EntityType::class, array(
                'class' => 'ParentingBundle\Entity\Subject',
                'choice_label' => 'name', 'multiple' => false
            ))
            ->add('price')
            ->add('degree')
            ->add('experience')
            ->add('linefb')
            ->add('phone')
            ->add('price')
            ->add('photo', PhotoType::class);


    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ParentingBundle\Entity\Teacher'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'parentingbundle_teacher';
    }


}
