<?php
/**
 * Created by PhpStorm.
 * User: leonardojsuarez
 * Date: 26/02/2018
 * Time: 09:11
 */
namespace Beaver\BackendBundle\Controller;

use Beaver\BackendBundle\Form\Security\PasswordRecoveryType;
use Beaver\CoreBundle\Response\BaseResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
	
	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 * @param bool                                      $username
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function recoverPassword(Request $request, $username = false)
	{
		if (false === $username) {
			return new RedirectResponse($this->get('router')->generate('login'));
		}
		
		$form = $this->createForm(PasswordRecoveryType::class, ['username' => $username]);
		
		$form->handleRequest($request);
		
		if (true === $form->isSubmitted() && true === $form->isValid()) {
			$username = $form->get('username')->getData();
			$password = $form->get('password')->getData();
			
			/** @var \Beaver\CoreBundle\Response\Interfaces\ResponseInterface $response */
			$response = $this->get('beaver.backend.security')->restorePassword($username, $password);
			
			if (BaseResponse::SUCCESS === $response->isSuccess()) {
				$this->addFlash('loginFlashMessage', 'Password generado correctamente!.');
				
				return $this->redirectToRoute('login');
			}
		}
		
		return $this->render('@Backend/Security/recover_password.html.twig', [
			'form'          => $form->createView(),
			'username'      => $username
		]);
	}
}
