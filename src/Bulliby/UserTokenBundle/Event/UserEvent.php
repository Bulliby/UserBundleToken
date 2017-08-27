<?php

namespace Bulliby\UserTokenBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use AppBundle\Entity\User as User;

class UserEvent extends Event
{
  private $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getUser()
  {
      return $this->user;
  }
}
