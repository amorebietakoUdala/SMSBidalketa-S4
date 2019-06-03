<?php

namespace App\Form;

use App\Entity\Label;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class LabelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $data = $options['data'];
//        $roles = $options['data']['roles'];
//        $locale = $options['data']['locale'];
        $builder
            ->add('id', HiddenType::class)
            ->add('name', null, [
                'constraints' => new NotBlank(),
                'attr' => ['class' => 'js-autocomplete'],
            ])
//            ->add('save', SubmitType::class, [
//            ])
//            ->add('back', ButtonType::class, [
//            ])
//            ->add('contacts', EntityType::class, [
//                'class' => Contact::class,
////                'allow_delete' => true,
////                'allow_add' => true,
////                'by_reference' => false,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Label::class,
            'roles' => null,
            'locale' => null,
        ]);
    }
}
