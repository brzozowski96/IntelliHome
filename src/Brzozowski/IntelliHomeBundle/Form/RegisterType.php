<?php

namespace Brzozowski\IntelliHomeBundle\Form;

use Brzozowski\IntelliHomeBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Imię'
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Nazwisko'
            ))
//            ->add('login', TextType::class, array(
//                'label' => 'Login'
//            ))
//            ->add('password', TextType::class, array(
//                'label' => 'Hasło'
//            ))
//            ->add('email', EmailType::class, array(
//                'label' => 'E-mail'
//            ))
            ->add('sex', ChoiceType::class, array(
                'label' => 'Płeć',
                'choices' => array(
                    'Mężczyzna' => 'm',
                    'Kobieta' => 'f'
                ),
                'expanded' => true,
            ))
            ->add('birthdate', BirthdayType::class, array(
                'label' => 'Data urodzenia',
                'empty_data' => NULL,
                'placeholder' => '--'
            ))
            ->add('role', ChoiceType::class, array(
                'label' => 'Rola',
                'choices' => array(
                    'Dziecko' => 'child',
                    'Rodzic' => 'parent',
                    'Lokator' => 'locator',
                    'Gość' => 'guest'
                ),
                'empty_data' => NULL,
                'placeholder' => '--'
            ))
            ->add('avatarFile', FileType::class, array(
                'label' => 'Avatar'
            ))
            ->add('rules', CheckboxType::class, array(
                'label' => 'Akceptuję regulamin',
                'mapped' => false
            ))
//            ->add('save', SubmitType::class, array(
//                'label' => 'Zarejestruj się'
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Brzozowski\IntelliHomeBundle\Entity\User'
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
        //return 'fos_user_registration';
    }

//    public function getName()
//    {
//        return 'app_user_registration';
//    }
}
