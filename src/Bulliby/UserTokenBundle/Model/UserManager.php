<?php

namespace Bulliby\UserTokenBundle\Model;

use AppBundle\Entity\User;
use Bulliby\UserTokenBundle\Model\BaseManager;
use Bulliby\UserTokenBundle\Event\UserEvent;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

class UserManager extends BaseManager
{

	private $dispatcher;

	public function __construct(EntityManager $em, Dispatcher $dispatcher)
	{
		$this->em = $em;
		$this->dispatcher = $dispatcher;
	}

	private function getRepository()
	{
		return $this->em->getRepository('BullibyUserTokenBundle:User');
	}

	public function loadUser(array $userDetails)
	{
		return $this->getRepository()->findOneBy($userDetails);
	}

	public function createUser()
	{
		$user = new User();
		return $user;
	}

	public function saveUser(User $user)
	{
        $user->setToken(md5(uniqid($user->getEmail(), true)));
		$this->dispatcher->dispatch('user.create', new UserEvent($user));
		$this->persistAndFlush($user);
	}
}
