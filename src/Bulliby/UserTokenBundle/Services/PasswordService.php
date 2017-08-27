<?php

/* ************************************************************************** */
/*                                                                            */
/*                                                                            */
/*   PasswordService.php                                                      */
/*                                                        ________            */
/*   By: bulliby <wellsguillaume@gmail.com>              /   ____/_  _  __    */
/*                                                      /    \  _\ \/ \/ /    */
/*   Created: 2017/06/03 23:19:14 by bulliby            \     \_\ \     /     */
/*   Updated: 2017/06/03 23:19:14 by bulliby             \________/\/\_/      */
/*                                                                            */
/* ************************************************************************** */

namespace Bulliby\UserTokenBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordService
{
	private $em;
    private $encoder;

	/**
	 * @param Object $em
	 *
	 */
	public function __construct(EntityManager $em, UserPasswordEncoderInterface $encoder)
	{
		$this->em =  $em;
        $this->encoder = $encoder;
	}

	/**
	 * Hash the password and return It.
	 *
	 * @param string $plainPassword
	 *
	 * @return string
	 */
	public function hashPassword($plainPassword, $user)
	{
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
		return $encoded;
	}

	/**
	 * Check if the hashs password are equals
	 *
	 * @param string $password1
	 * @param string $password2
	 *
	 * @return bool
	 */
	public function verifyPassword($plainPassword, $hash)
	{
		return (password_verify($plainPassword, $hash));
	}

	/**
	 * Get the user password
	 *
	 * @param int $userId
	 *
	 * @return string
	 */
	public function getUserPassword($userId)
	{
		
	}
}
