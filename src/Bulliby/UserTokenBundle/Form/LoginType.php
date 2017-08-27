<?php

namespace Bulliby\UserTokenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('login', TextType::class, [
				'constraints' => [
					new Length([
						'min' => 3,
						'max' => 20,
						'minMessage' => "Your login must be at least {{ limit }} characters long",
						'maxMessage' => "Your login cannot be longer than {{ limit }} characters"
					]),
					new NotBlank()
				]
			])
			->add('password', PasswordType::class, [
				'constraints' => [
					new NotBlank()
				]
			])
            ->add('Login', SubmitType::class)
        ;
    }
}
