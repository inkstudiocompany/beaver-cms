<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 26/02/2018
 * Time: 09:11
 */

namespace Beaver\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="login")
	 */
	public function login(Request $request, AuthenticationUtils $authUtils)
	{
		// get the login error if there is one
		$error = $authUtils->getLastAuthenticationError();
		
		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername();
		
		return $this->render('@Backend/Security/login.html.twig', array(
			'last_username' => $lastUsername,
			'error'         => $error,
		));
	}
}
