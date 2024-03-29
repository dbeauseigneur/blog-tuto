<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
	/**
	 * @Route("/login", name="app_login")
	 **/
	public function index(AuthenticationUtils $authenticationUtils): Response
	{

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		$theme = 'cerulean';
		return $this->render('login.html.twig', [
			'controller_name' => 'LoginController',
			'theme' => $theme,
			'error' => $error,
			'last_username' => $lastUsername
		]);
	}
}
