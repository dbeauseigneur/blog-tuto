<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
	#[Route('/{theme<%themes%>}', name: 'homepage')]

	public function main(string $theme, ManagerRegistry $doctrine): Response
	{
		$em = $doctrine->getManager();
		$postRepository = $em->getRepository(Post::class);
		$carouselArticles = $postRepository->getLastSixArticles(6);

		if ($theme === '') {
			return $this->render('front/start.html.twig');
		}
		return $this->render('front/index.html.twig', ['theme' => $theme, 'carouselArticles' => $carouselArticles]);
	}


	#[Route('/{theme<%themes%>}/a-propos', name: 'a_propos')]

	public function aPropos(string $theme): Response
	{
		if ($theme === '') {
			$this->redirectToRoute('a_propos', [$this->getParameter('default-theme')]);
		}
		return $this->render('front/a-propos.html.twig', ['theme' => $theme]);
	}

	#[Route('/{theme<%themes%>}/contact', name: 'contact')]
	public function contact(MailerInterface $message, Request $request, string $theme): Response
	{
		if ($theme === '') {
			$this->redirectToRoute('contact', [$this->getParameter('default-theme')]);
		}
		$defaultData = ['message' => 'Écrivez votre message ici'];
		$form = $this->createFormBuilder($defaultData)
			->add('firstName', TextType::class, array('label' => 'Prénom'))
			->add('lastName', TextType::class, array('label' => 'Nom'))
			->add('email', EmailType::class, array('label' => 'Email'))
			->add('message', TextareaType::class, array('label' => 'Message'))
			->add('tel', TelType::class, array('label' => 'Téléphone'))
			->add('send', SubmitType::class)
			->add('captcha', CaptchaType::class)
			->getForm();
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

			$email = $defaultData["email"];
			$messageContact = $defaultData["message"];
			$lastName = $defaultData["last_name"];
			$firstName = $defaultData["first_name"];
			$tel = $defaultData["tel"];
			$mailTo = $this->getParameter('mail-perso');
			$mailContent = "Bonjour Damien, " . "<br><br>" . "Vous avez reçu une nouvelle demande de contact : "
				. 'email : ' . $email . '<br />' . 'Prénom : ' . $firstName . '<br />' . 'Nom : ' . $lastName . '<br />'
				. 'N° de téléphone : ' . $tel . '<br /><br />' . $messageContact;

			$email = (new Email())
				->subject("Une nouvelle demande de contact")
				->to($mailTo)
				->html($mailContent);

			$message->send($email);

			return $this->redirectToRoute('contact', array('theme' => $theme));
		}

		return $this->render('front/contact.html.twig', ['theme' => $theme, 'form' => $form->createView()]);
	}

	#[Route('/{theme<%themes%>}/mention', name: 'mentions')]
	public function mention(string $theme): Response
	{
		if ($theme === '') {
			$this->redirectToRoute('contact', [$this->getParameter('default-theme')]);
		}
		return $this->render('front/mentions.html.twig', ['theme' => $theme]);
	}

}
