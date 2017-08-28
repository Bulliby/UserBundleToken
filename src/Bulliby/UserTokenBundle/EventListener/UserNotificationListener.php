<?php

namespace Bulliby\UserTokenBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Bulliby\UserTokenBundle\Event\UserEvent;
use Bulliby\UserTokenBundle\Services\PasswordService;

class UserNotificationListener implements EventSubscriberInterface
{
  private $encoder;

  public function __construct(PasswordService $encoder)
  {
    $this->encoder = $encoder;
  }

  public function onUserCreate(UserEvent $event)
  {
	$user = $event->getUser();
	$encoded = $this->encoder->hashPassword($user->getPassword(), $user);
	$user->setPassword($encoded);
  }

  public static function getSubscribedEvents()
  {
    return [
      'user.create' => 'onUserCreate',
    ];
  }
}
