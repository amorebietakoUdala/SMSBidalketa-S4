<?php

namespace App\Form;

use App\Entity\Label;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SendByLabelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $data = $options['data'];
//        $roles = $options['data']['roles'];
//        $locale = $options['data']['locale'];
        $builder
            ->add('labels', EntityType::class, [
                'class' => Label::class,
                'multiple' => 'multiple',
                'label' => 'labels',
                'choice_label' => 'name',
//                'placeholder' => 'Choose an option',
            ])
            ->add('selected', \Symfony\Component\Form\Extension\Core\Type\HiddenType::class)
            ->add('message', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, [
                    'attr' => ['maxlength' => 255],
                    'label' => 'message',
                ])
//            ->add('save', SubmitType::class, [
//            ])
//            ->add('back', ButtonType::class, [
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => \App\DTO\SendByLabelDTO::class,
            'roles' => null,
            'locale' => null,
        ]);
    }
}
