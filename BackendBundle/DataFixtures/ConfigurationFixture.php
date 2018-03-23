<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 22/03/2018
 * Time: 22:39
 */

namespace Beaver\BackendBundle\DataFixtures;

use Beaver\BackendBundle\Entity\BackendUser;
use Beaver\BackendBundle\Security\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ConfigurationFixture
 *
 * @package Beaver\BackendBundle\DataFixtures
 */
class ConfigurationFixture extends Fixture
{
	/**
	 * @param \Doctrine\Common\Persistence\ObjectManager $manager
	 *
	 * @throws \Exception
	 */
	public function load(ObjectManager $manager)
	{
		try {
			$user = new BackendUser();
			$user
				->setName('Root')
				->setLastname('Beaver')
				->setEmail('info@beaver.com')
				->setStatus(UserProvider::INACTIVE)
				->setPassword('UNDEFINED')
				->setRol(1)
				->setUsername('root')
			;
			$manager->persist($user);
			$manager->flush();
		} catch (\Exception $exception) {
			throw $exception;
		}
	}
}