<?php

namespace App\Form;

use App\Entity\Label;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SendingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('labels', EntityType::class, [
                'class' => Label::class,
                'multiple' => 'multiple',
                'label' => 'contact.labels',
                'choice_label' => 'name',
            ])
            ->add('selected', \Symfony\Component\Form\Extension\Core\Type\HiddenType::class)
            ->add('message', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, [
                    'attr' => ['maxlength' => 335],
                    'label' => 'sending.message',
            ])
            ->add('date', \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'sending.date',
//                    ],
                    'html5' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\DTO\SendingDTO::class,
            'roles' => null,
            'locale' => null,
        ]);
    }
}
