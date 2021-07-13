<?php

namespace App\Form;

use App\Entity\EmailMessage;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, $this->getConfiguration("Prénom", "Votre prénom..."))
        ->add('lastname', TextType::class, $this->getConfiguration("Nom", "Votre nom de famille..."))
        ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email..."))
        ->add('content', TextareaType::class, $this->getConfiguration("Message","Votre message !"))
        ->add('recaptcha', EWZRecaptchaType::class, [
            'label' => false,
            'mapped'=> false,
            'attr' => array(
                'options' => array(
                    'theme' => 'dark',
                    'type'  => 'image',
                    'size'  => 'compact'
                ),
            ),
            'constraints' => [
                new RecaptchaTrue(),
            ],
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmailMessage::class,
        ]);
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        // return FormType::class to modify (nearly) every field in the system
        return [FileType::class];
    }
}
