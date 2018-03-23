<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 22/03/2018
 * Time: 21:03
 */

namespace Beaver\BackendBundle\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityManager;
use Beaver\BackendBundle\Entity\BackendUser;

/**
 * Class UserProvider
 *
 * @package Beaver\BackendBundle\Security
 */
class UserProvider implements UserProviderInterface
{
	const ACTIVE    = 1;
	const DISABLED  = 0;
	const INACTIVE  = 99;
	
	/**
	 * @var EntityManager
	 */
	private $entityManager;
	
	/**
	 * UserProvider constructor.
	 *
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
	
	/**
	 * Loads the user for the given username.
	 *
	 * This method must throw UsernameNotFoundException if the user is not
	 * found.
	 *
	 * @param string $username The username
	 *
	 * @return UserInterface
	 *
	 * @throws UsernameNotFoundException if the user is not found
	 */
	public function loadUserByUsername($username)
	{
		$backendUser = $this->entityManager->getRepository(BackendUser::class)->findOneBy([
			'username'  => $username
		]);
		
		if (!$backendUser) {
			throw new UsernameNotFoundException(
				sprintf('Username "%s" does not exist.', $username)
			);
		}
		
		// Validación que obliga al definir la contraseña de usuario.
		if (self::INACTIVE === $backendUser->getStatus()) {
			throw new UsernameNotFoundException('Usuario no actualizado', self::INACTIVE);
		}
		
		$user = new User($username, $backendUser->getPassword(), null, ['ROLE_ADMIN']);
		
		return $user;
	}
	
	/**
	 * Refreshes the user.
	 *
	 * It is up to the implementation to decide if the user data should be
	 * totally reloaded (e.g. from the database), or if the UserInterface
	 * object can just be merged into some internal array of users / identity
	 * map.
	 *
	 * @return UserInterface
	 *
	 * @throws UnsupportedUserException if the user is not supported
	 */
	public function refreshUser(UserInterface $user)
	{
		if (false === $user instanceof BackendUser) {
			throw new UnsupportedUserException(
				sprintf('Instances of "%s" are not supported.', get_class($user))
			);
		}
		
		return $this->loadUserByUsername($user->getUsername());
	}
	
	/**
	 * Whether this provider supports the given user class.
	 *
	 * @param string $class
	 *
	 * @return bool
	 */
	public function supportsClass($class)
	{
		return $class === 'Beaver\BackendBundle\Security\BackendUser';
	}
}