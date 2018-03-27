<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 22/03/2018
 * Time: 23:04
 */

namespace Beaver\BackendBundle\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Class PasswordRecoveryType
 *
 * @package Beaver\BackendBundle\Form\Security
 */
class PasswordRecoveryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username', HiddenType::class, [
				'required'  => true,
				'attr' => [
					'required'      => true,
					'placeholder'   => 'Username/Email',
					'disabled'      => false
				]
			])
			->add('password', RepeatedType::class, [
				'type'              => PasswordType::class,
				'invalid_message'   => 'Las contraseñas no coinciden',
				'required'          => true,
				'attr'              => [
					'data-rule-required'    => true,
					'data-msg-required'     => 'Ingrese una contraseña',
					'data-rule-minlength'   => 6,
					'data-msg-minlength'    => 'La contraseña debe tener mínimo 6 caracteres'
				],
				'first_options'     => [
					'label'         => 'Password',
					'attr'              => [
						'required'              => true,
						'data-rule-minlength'   => 6,
						'data-msg-minlength'    => 'La contraseña debe tener mínimo 6 caracteres'
					],
				],
				'second_options'    => [
					'label'         => 'Repeat Password',
					'attr'              => [
						'required'              => true,
						'data-rule-minlength'   => 6,
						'data-msg-minlength'    => 'La contraseña debe tener mínimo 6 caracteres',
						'data-rule-equalto'     => '#recover_password_password_first',
						'data-msg-equalto'      => 'Las contraseñas no coinciden'
					],
				],
				'constraints'       => [
					new NotBlank(),
					new Length([
						'min'           => 6,
						'minMessage'    => 'La contraseña debe tener mínimo 6 caracteres'
					])
				]
			])
			->add('submit_button', SubmitType::class, [
				'label'             => 'Restaurar'
			]);
		;
	}
	
}