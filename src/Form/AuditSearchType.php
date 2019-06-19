<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuditSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromDate', null, [
                'label' => 'audit.fromDate',
            ])
            ->add('toDate', null, [
                'label' => 'audit.toDate',
            ])
            ->add('contacts', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [
                'class' => \App\Entity\Contact::class,
                'multiple' => 'multiple',
                'label' => 'contacts',
                'choice_label' => 'telephone',
//                'placeholder' => 'Choose an option',
            ])
//            ->add('responseCode', null, [
//                'label' => 'audit.responseCode',
//            ])
//            ->add('message', null, [
//                'label' => 'audit.message',
//            ])
//            ->add('response', null, [
//                'label' => 'audit.response',
//            ])
            ->add('user', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [
                'class' => \App\Entity\User::class,
                'multiple' => false,
                'label' => 'audit.user',
                'choice_label' => 'username',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
