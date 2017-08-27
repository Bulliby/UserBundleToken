<?php

namespace Bulliby\UserTokenBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $router;
    private $encoder;

    public function __construct(
        RouterInterface $router, 
        UserPasswordEncoderInterface  $encoder
        )
    {
        $this->router = $router;
        $this->encoder = $encoder;
    }
    /**
     * Return the URL to the login page.
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->router->generate('login');
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser(). Returning null will cause this authenticator
     * to be skipped.
     */
    public function getCredentials(Request $request)
    {
        if ($this->router->generate('login', array(), RouterInterface::ABSOLUTE_URL) 
            != $request->getUri() 
            || !$request->isMethod('POST')) {
            return;
        }
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        return [
            'username' => $username,
            'password' => $password,
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];
        return $userProvider->loadUserByUsername($username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->encoder->isPasswordValid($user, $credentials['password'])) 
            return true;
        else
            return false;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $session = new Session();
        $session->getFlashBag()->add('success', 'You are now logged-in');
        return new RedirectResponse($this->router->generate('homepage'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
