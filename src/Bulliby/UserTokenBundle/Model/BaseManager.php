<?php

namespace Bulliby\UserTokenBundle\Model;

abstract class BaseManager
{
	protected function persistAndFlush($entity)
	{
		$this->em->persist($entity);
		$this->em->flush();
	}
}
