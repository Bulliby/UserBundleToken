<?php

namespace Bulliby\UserTokenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @author Wells Guillaume
 * @ORM\MappedSuperclass
 */
abstract class UserBase implements UserInterface, \Serializable, EquatableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
	 * @var string
	 * UserInterface Required
	 * @Assert\Length(
	 *	min=3,
	 *  max=20,
	 *  minMessage="Your login must be at least {{ limit }} characters long",
	 *  maxMessage="Your login cannot be longer than {{ limit }} characters"
	 *)
	 * @ORM\Column(name="username", type="string", length=20)
	 */
	protected $username;

	/**
	 * @var string
	 * @Assert\Length(
	 *	min = 8,
	 *  max = 20,
	 *  minMessage = "Your password must be at least {{ limit }} characters long",
	 *  maxMessage = "Your password cannot be longer than {{ limit }} characters"
	 * )
	 * @Assert\Regex(
	 *  pattern="/\d+/",
	 *  match=true,
	 *  message="Your password must contain at least one numeric value"
	 * )
	 * @Assert\Regex(
	 *  pattern="/[^a-zA-Z\d\s:]/",
	 *  match=true,
	 *  message="Your password must contain at least one non-alphanumeric character"
	 * )
	 * @ORM\Column(name="password", type="string", length=255)
	 */
	protected $password;

	/**
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

	/**
     * @var string
     *
     * @ORM\Column(name="salt", type="string")
     */
    private $salt;


    public function __construct()
    {
        $this->salt = uniqid("", true);
    }

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set username
	 *
	 * @param string $login
	 *
	 * @return UserBase
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}


	/**
	 * Get username
	 * UserInterface Required
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return UserBase
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get password
	 * UserInterface Required
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Get salt
	 * UserInterface Required
	 *
	 * @return string
	 */
	public function getSalt()
    {
        return $this->salt;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    public function isEqualTo(UserInterface $user)
    {
        return $this->id === $user->getId();
    }

	public function eraseCredentials()
    {
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }
}
