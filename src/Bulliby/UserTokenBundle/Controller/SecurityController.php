<?php

namespace Bulliby\UserTokenBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Bulliby\UserBundle\Form\LoginType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
	public function loginAction(Request $request)
	{
        $authenticationUtils = $this->get('security.authentication_utils');
		// get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('BullibyUserTokenBundle:Login:login.html.twig', array(
			'last_username' => $lastUsername,
			'error'         => $error,
		));
	}
}
