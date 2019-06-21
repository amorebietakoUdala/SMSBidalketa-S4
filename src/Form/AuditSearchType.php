<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('contacts', EntityType::class, [
                'class' => Contact::class,
                'multiple' => 'multiple',
                'label' => 'contacts',
                'choice_label' => 'telephone',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
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
