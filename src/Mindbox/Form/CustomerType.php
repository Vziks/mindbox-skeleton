<?php

namespace App\Mindbox\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Фамилия',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Фамилия',
                    'class' => 'form-control'
                ],

            ])
            ->add('firstName', TextType::class, [
                'label' => 'Имя',
                'required' => true,
                'attr' => ['placeholder' => 'Имя'],
            ])
            ->add('middleName', TextType::class, [
                'label' => 'Отчество',
                'required' => true,
                'attr' => ['placeholder' => 'Отчество'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Ваша электронная почта',
                'required' => true,
            ])
            ->add('mobilePhone', TextType::class, [
                'label' => 'Номер телефона',
                'required' => true,
                //'mapped' => false,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Введите пароль',
                'required' => true,
            ])
            ->add('emailSubscription', CheckboxType::class, [
                'label' => 'Согласен на рассылку по email',
                'required' => false,
                'mapped' => false,
            ])
            ->add('smsSubscription', CheckboxType::class, [
                'label' => 'Согласен на рассылку по sms',
                'required' => false,
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Отправить']);
    }

    public function getBlockPrefix()
    {
        return 'app_customer_type';
    }
}
