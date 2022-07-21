<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
	/**
	 * @Route("/{theme<%themes%>}", name="homepage")
	 */
	public function main(string $theme): Response
	{
		if ($theme == '') {
			return $this->redirectToRoute('homepage', ['theme' => ($this->getParameter('default-theme'))]);
		}
		return $this->render('base.html.twig', ['theme' => $theme]);
	}

	/**
	 * @Route("/{theme<%themes%>}/a-propos", name="a_propos")
	 */
	public function aPropos(string $theme): Response
	{
		if ($theme === '') {
			$this->redirectToRoute('a_propos', [$this->getParameter('default-theme')]);
		}
		return $this->render('base.html.twig', ['theme' => $theme]);
	}

	/**
	 * @Route("/{theme<%themes%>}/qui-suis-je", name="qui-suis-je")
	 */
	public function whoIAm(string $theme): Response
	{
		if ($theme === '') {
			$this->redirectToRoute('qui-suis-je', [$this->getParameter('default-theme')]);
		}
		return $this->render('base.html.twig', ['theme' => $theme]);
	}

	/**
	 * @Route("/{theme<%themes%>}/contact", name="contact")
	 */
	public function contact(string $theme): Response
	{
		if ($theme === '') {
			$this->redirectToRoute('contact', [$this->getParameter('default-theme')]);
		}
		return $this->render('base.html.twig', ['theme' => $theme]);
	}

	/**
	 * @Route("/mention", name="mentionslegales")
	 */
	public function mention(): Response
	{
		return $this->render('base.html.twig', []);
	}

}