<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Comment;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
 * Category controller.
 * @route("/{theme<%themes%>}/blog")
 */
class CategoryController extends AbstractController
{
	public const MAX_PER_PAGE = 4;

	/**
	 * @param string $theme
	 * @param Category $category
	 * @param ManagerRegistry $doctrine
	 * @param int $page
	 * @return Response
	 * @route("/categorie/{slug}/{page}",name="category_blog")
	 */
	public function filterIndex(string $theme, Category $category, ManagerRegistry $doctrine, int $page = 1): Response
	{
		$em = $doctrine->getManager();

		$posts = $em->getRepository(Post::class)->categoryGetByPage($category, $page, self::MAX_PER_PAGE);
		$archive = $em->getRepository(Post::class)->getAllOrderByDate();
		$categories = $em->getRepository(Category::class)->getAllOrderByName();

		$total = count($posts);
		$maxPage = (int)($total / PostRepository::MAX_RESULT);
		if (($total % PostRepository::MAX_RESULT) !== 0) {
			$maxPage++;
		}
		return $this->render('front/article-categorie.html.twig', array(
			'category' => $category,
			'maxPage' => $maxPage,
			'posts' => $posts,
			'page' => $page,
			'archive' => $archive,
			'categories' => $categories,
			'theme' => $theme
		));

	}
}
