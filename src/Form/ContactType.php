<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $data = $options['data'];
//        $roles = $options['data']['roles'];
//        $locale = $options['data']['locale'];
        $builder
            ->add('username', null, [
                'constraints' => new NotBlank(),
            ])
            ->add('telephone', null, [
                'constraints' => new NotBlank(),
            ])
            ->add('name', null, [
                'constraints' => new NotBlank(),
            ])
            ->add('surname1', null, [
                'constraints' => new NotBlank(),
            ])
            ->add('surname2', null, [
            ])
            ->add('company')
            ->add('department')
            ->add('labels', CollectionType::class, [
                'entry_type' => LabelType::class,
                'allow_delete' => true,
                'allow_add' => true,
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
            'data_class' => ContactDTO::class,
            'roles' => null,
            'locale' => null,
        ]);
    }
}
