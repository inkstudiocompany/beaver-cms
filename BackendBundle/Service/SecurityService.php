<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 22/03/2018
 * Time: 23:25
 */

namespace Beaver\BackendBundle\Service;

use Beaver\BackendBundle\Entity\BackendUser;
use Beaver\BackendBundle\Security\User;
use Beaver\BackendBundle\Security\UserProvider;
use Beaver\CoreBundle\Response\BooleanResponse;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

/**
 * Class SecurityService
 *
 * @package Beaver\BackendBundle\Service
 */
class SecurityService
{
	/** @var \Doctrine\ORM\EntityManager */
	private $entityManager;
	
	/** @var \Symfony\Component\Security\Core\Encoder\EncoderFactory */
	private $encoderFactory;
	
	/**
	 * SecurityService constructor.
	 *
	 * @param \Doctrine\ORM\EntityManager                             $entityManager
	 * @param \Symfony\Component\Security\Core\Encoder\EncoderFactory $encoderFactory
	 */
	public function __construct(EntityManager $entityManager, EncoderFactory $encoderFactory)
	{
		$this->entityManager    = $entityManager;
		$this->encoderFactory   = $encoderFactory;
	}
	
	/**
	 * @param bool $username
	 * @param bool $password
	 *
	 * @return \Beaver\CoreBundle\Response\BooleanResponse
	 */
	public function restorePassword($username = false, $password = false)
	{
		$restoreResponse = new BooleanResponse();
		
		try {
			if (false === $username || false === $password) {
				$restoreResponse->setError('Los parámetros username y password son obligatorios.');
			}
			
			$user = $this->entityManager->getRepository(BackendUser::class)->findOneBy([
				'username'  => $username
			]);
			
			if (!$user) {
				return $restoreResponse->setError('El nombre de usuario no se encuentra registrado.');
			}
			
			$securityUser = new User($user->getUsername(), $user->getPassword(), null, ['ROLE_ADMIN']);
			
			$user->setPassword($this->encoderFactory->getEncoder($securityUser)->encodePassword($password, null));
			$user->setStatus(UserProvider::ACTIVE);
			
			$this->entityManager->persist($user);
			$this->entityManager->flush();
		} catch (\Exception $exception) {
			$restoreResponse->setError($exception->getMessage());
		}
		
		return $restoreResponse;
	}
}