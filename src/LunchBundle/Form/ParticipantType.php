<?php

namespace LunchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParticipantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email');
        $builder->add('department', 'choice', [
            'choices' => [
                'IT' => 'IT',
                'SALES' => 'SALES',
                'OPS' => 'OPS'
            ]
        ]);
        $builder->add('save', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'LunchBundle\Entity\Participant'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lunchbundle_participant';
    }
}
