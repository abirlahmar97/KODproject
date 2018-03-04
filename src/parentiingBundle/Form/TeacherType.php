<?php

namespace parentiingBundle\Form;

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
        ->add('lastname')
            ->add('subject', EntityType::class, array('class' => 'parentiingBundle\Entity\Subject','choice_label' => 'name', 'multiple' => false))
            ->add('price')
            ->add('linefb')
            ->add('phone')
            ->add('photo', PhotoType::class);


    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'parentiingBundle\Entity\Teacher'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'parentiingbundle_teacher';
    }


}