<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 22/03/2018
 * Time: 20:48
 */

namespace Beaver\BackendBundle\Security;

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @package Beaver\BackendBundle\Security
 */
class User implements UserInterface, EquatableInterface
{
	/** @var int */
	private $id;

	/** @var string */
	private $name;
	
	/** @var string */
	private $lastname;
	
	/** @var string */
	private $email;
	
	/** @var int */
	private $rol;
	
	/** @var array */
	private $roles;
	
	/** @var string */
	private $username;
	
	/** @var string */
	private $password;
	
	/** @var string */
	private $salt;
	
	/** @var array */
	private $menu;
	
	/**
	 * BackendUser constructor.
	 *
	 * @param       $username
	 * @param       $password
	 * @param       $salt
	 * @param array $roles
	 */
	public function __construct($username, $password, $salt, array $roles)
	{
		$this->username = $username;
		$this->password = $password;
		$this->salt     = $salt;
		$this->roles    = $roles;
	}
	
	/**
	 * The equality comparison should neither be done by referential equality
	 * nor by comparing identities (i.e. getId() === getId()).
	 *
	 * However, you do not need to compare every attribute, but only those that
	 * are relevant for assessing whether re-authentication is required.
	 *
	 * Also implementation should consider that $user instance may implement
	 * the extended user interface `AdvancedUserInterface`.
	 *
	 * @return bool
	 */
	public function isEqualTo(UserInterface $user)
	{
		if (!$user instanceof User) {
			return false;
		}
		
		if ($this->password !== $user->getPassword()) {
			return false;
		}
		
		if ($this->salt !== $user->getSalt()) {
			return false;
		}
		
		if ($this->username !== $user->getUsername()) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Returns the roles granted to the user.
	 *
	 * <code>
	 * public function getRoles()
	 * {
	 *     return array('ROLE_USER');
	 * }
	 * </code>
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return (Role|string)[] The user roles
	 */
	public function getRoles()
	{
		return $this->roles;
	}
	
	/**
	 * Returns the password used to authenticate the user.
	 *
	 * This should be the encoded password. On authentication, a plain-text
	 * password will be salted, encoded, and then compared to this value.
	 *
	 * @return string The password
	 */
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * Returns the salt that was originally used to encode the password.
	 *
	 * This can return null if the password was not encoded using a salt.
	 *
	 * @return string|null The salt
	 */
	public function getSalt()
	{
		return $this->salt;
	}
	
	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 */
	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}
}