<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'constraints' => new NotBlank(),
                'label' => 'contact.username',
            ])
            ->add('telephone', null, [
                'constraints' => [new NotBlank(),
                                   new Regex('/^(71|72|73|74)\d{7}+$|^6\d{8}+$/'),
                    ],
                'label' => 'contact.telephone',
            ])
            ->add('name', null, [
                'constraints' => new NotBlank(),
                'label' => 'contact.name',
            ])
            ->add('surname1', null, [
                'constraints' => new NotBlank(),
                'label' => 'contact.surname1',
            ])
            ->add('surname2', null, [
                'label' => 'contact.surname2',
            ])
            ->add('company', null, [
                'label' => 'contact.company',
            ])
            ->add('department', null, [
                'label' => 'contact.department',
            ])
            ->add('labels', CollectionType::class, [
                'entry_type' => LabelType::class,
                'allow_delete' => true,
                'allow_add' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
