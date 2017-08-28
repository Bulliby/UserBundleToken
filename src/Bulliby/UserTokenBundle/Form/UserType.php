<?php

namespace Bulliby\UserTokenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

use Bulliby\UserTokenBundle\Form\MyPasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
			->add('birthday', BirthdayType::class)
			->add('email')
			->add('familly')
			->add('username')
			->add('password', MyPasswordType::class, array(
				'data_class' => UserType::class,
				'label' => false
			))
			//->add('password', MyPasswordType::class, array('label' => false))
            ->add('Register', SubmitType::class)
        ;
    }
}
