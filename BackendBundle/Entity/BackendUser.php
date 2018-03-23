<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 22/03/2018
 * Time: 21:02
 */

namespace Beaver\BackendBundle\Entity;

use Beaver\BackendBundle\Security\UserProvider;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="beaver_user")
 */
class BackendUser
{
	/**
	 * @ORM\Column(type="integer", name="id", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=50, name="name", nullable=false)
	 */
	private $name;
	
	/**
	 * @ORM\Column(type="string", length=70, name="lastname", nullable=false)
	 */
	private $lastname;
	
	/**
	 * @ORM\Column(type="integer", name="status", nullable=false)
	 */
	private $status = UserProvider::INACTIVE;
	
	/**
	 * @ORM\Column(type="integer", name="rol", nullable=false)
	 */
	private $rol;
	
	/**
	 * @ORM\Column(type="string", name="email", length=70, nullable=false)
	 */
	private $email;
	
	/**
	 * @ORM\Column(type="string", name="username", length=50, nullable=false)
	 */
	private $username;
	
	/**
	 * @ORM\Column(type="string", name="password", nullable=false)
	 */
	private $password = 'UNDEFINED';
	
	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}
	
	/**
	 * @param int $id
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setId(int $id): BackendUser
	{
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}
	
	/**
	 * @param string $name
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setName(string $name): BackendUser
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getLastname(): string
	{
		return $this->lastname;
	}
	
	/**
	 * @param string $lastname
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setLastname(string $lastname): BackendUser
	{
		$this->lastname = $lastname;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getStatus(): int
	{
		return $this->status;
	}
	
	/**
	 * @param int $status
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setStatus(int $status): BackendUser
	{
		$this->status = $status;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getRol(): int
	{
		return $this->rol;
	}
	
	/**
	 * @param int $rol
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setRol(int $rol): BackendUser
	{
		$this->rol = $rol;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}
	
	/**
	 * @param string $email
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setEmail(string $email): BackendUser
	{
		$this->email = $email;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getUsername(): string
	{
		return $this->username;
	}
	
	/**
	 * @param string $username
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setUsername(string $username): BackendUser
	{
		$this->username = $username;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPassword(): string
	{
		return $this->password;
	}
	
	/**
	 * @param string $password
	 *
	 * @return \Beaver\BackendBundle\Entity\BackendUser
	 */
	public function setPassword(string $password): BackendUser
	{
		$this->password = $password;
		return $this;
	}
}
