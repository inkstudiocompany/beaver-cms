<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 22/03/2018
 * Time: 22:22
 */

namespace Beaver\BackendBundle\Listeners;


use Beaver\BackendBundle\Security\UserProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\HttpUtils;

/**
 * Class AuthenticationListener
 *
 * @package Beaver\BackendBundle\Listeners
 */
class AuthenticationListener implements AuthenticationFailureHandlerInterface
{
	/** @var \Symfony\Component\Routing\Router */
	private $router;
	
	/** @var HttpUtils */
	private $httpUtils;
	
	/**
	 * AuthenticationListener constructor.
	 *
	 * @param Router    $router
	 * @param HttpUtils $httpUtils
	 */
	public function __construct(Router $router, HttpUtils $httpUtils)
	{
		$this->router       = $router;
		$this->httpUtils    = $httpUtils;
	}
	
	/**
	 * This is called when an interactive authentication attempt fails. This is
	 * called by authentication listeners inheriting from
	 * AbstractAuthenticationListener.
	 *
	 * @return Response The response to return, never null
	 */
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		if (true === $exception->getPrevious() instanceof UsernameNotFoundException) {
			if (UserProvider::INACTIVE === $exception->getPrevious()->getCode()) {
				return new RedirectResponse(
					$this->router->generate('beaver.backend.password.restore', ['username' => $request->get('_username')]));
			}
		}
		
		$request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
		$request->getSession()->save();
		$request->attributes->set(Security::AUTHENTICATION_ERROR, $exception->getMessage());
		
		return $this->httpUtils->createRedirectResponse($request, $this->router->generate('login'));
	}
}