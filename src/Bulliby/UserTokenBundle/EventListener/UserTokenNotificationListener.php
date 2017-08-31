<?php

namespace Bulliby\UserTokenBundle\EventListener;

use Bulliby\UserBundle\EventListener\UserNotificationListener;
use Bulliby\UserBundle\Event\UserEvent;

class UserTokenNotificationListener extends UserNotificationListener
{
  public function onUserLogged(UserEvent $event)
  {
	$user = $event->getUser();
    $user->setToken(md5(uniqid($user->getEmail(), true)));
    $this->em->persist($user);
    $this->em->flush();
  }

  public static function getSubscribedEvents()
  {
    return [
      'user.create' => 'onUserCreate',
      'user.logged' => 'onUserLogged',
    ];
  }
}
