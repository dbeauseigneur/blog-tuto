<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use app\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Post;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

/**
 * @Route("/{theme<%themes%>}/blog")
 */
class PostController extends AbstractController
{
	/**
	 * Lists all Post entities.
	 *
	 */
	private const MAX_PER_PAGE = 4;

	/**
	 * @Route("/{page<d+>}", name="blog")
	 */
	public function index(string $theme, ManagerRegistry $doctrine, int $page = 1): Response
	{

		$em = $doctrine->getManager();

		$postRepository = $em->getRepository(Post::class);
		$categoryRepository = $em->getRepository(Category::class);
		$post = $postRepository->getByPage($page, self::MAX_PER_PAGE);
		$archive = $postRepository->getAllOrderByDate();
		$categories = $categoryRepository->getAllOrderByName();

		$total = count($post);
		$maxPage = (int)($total / PostRepository::MAX_RESULT);
		if (($total % PostRepository::MAX_RESULT) !== 0) {
			$maxPage++;
		}
		return $this->render('front/blog.html.twig', array(

			'maxPage' => $maxPage,
			'posts' => $post,
			'page' => $page,
			'archive' => $archive,
			'categories' => $categories,
			'theme' => $theme

		));

	}

	/**
	 * @route ("/{link}", name="article_blog")
	 * @param MailerInterface $message
	 * @param ManagerRegistry $doctrine
	 * @param Post $post
	 * @param Request $request
	 * @param string $theme
	 * @return Response
	 *
	 * @throws TransportExceptionInterface
	 */
	public function show(MailerInterface $message, ManagerRegistry $doctrine, Post $post, Request $request, string $theme): Response
	{

		$comment = new Comment();
		$comment->setPostId($post);
		$formComment = $this->createFormBuilder($comment)
			->add('author', TextType::class, array('label' => 'Prénom et Nom'))
			->add('authorEmail', TextType::class, array('label' => 'E-mail'))
			->add('content', TextareaType::class, array('label' => 'Message'))
			->add('captcha', CaptchaType::class)
			->getForm();// for valid captcha
		$formComment->handleRequest($request);
		if ($formComment->isSubmitted() && $formComment->isValid()) {
			$em = $doctrine->getManager();
			$em->persist($comment);
			$em->flush();

			$name = $comment->getAuthor();
			$emailName = $comment->getAuthorEmail();
			$title = $comment->getTitle();
			$commentContent = $comment->getContent();
			$url = $post->getLink();
			$article = $post->getTitle();

			$mailTo = $this->getParameter('mail-perso');

			$email = (new Email())
				->subject("Un nouveau commentaire sur votre blog")
				->to($mailTo)
				->html("Bonjour Damien, " . "<br><br>" . "Vous avez reçu un nouveau commentaire sur l'article : " . "<a href=" . $url . ">" . $article . "</a>" . "<br><br>" . "Rendez-vous sur la page Admin : <a href=" . "'https://www.lafolleagence.com/admin'" . ">Cliquez ici</a>" . "<br><br>" . "Nom : " . $name . "<br>" . "email : " . $emailName . "<br>" . "titre : " . $title . "<br><br>" . "Commentaire : " . "<br><br>" . $commentContent . "<br><br><br>" . "Cordialement,");

			$message->send($email);

			return $this->redirectToRoute('article_blog', array('link' => $post->getLink(), 'theme' => $theme));
		}

		$em = $doctrine->getManager();
		$archive = $em->getRepository(Post::class)->getAllOrderByDate();
		$categories = $em->getRepository(Category::class)->getAllOrderByName();
		$comments = $post->getComments();
		return $this->render('front/article-blog.html.twig', array(
			'post' => $post,
			'archive' => $archive,
			'categories' => $categories,
			'comments' => $comments,
			'formComment' => $formComment->createView(),
			'theme' => $theme
		));

	}
}
