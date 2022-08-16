<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use App\Entity\Tuto;

/**
 * Category controller.
 * @route("/{theme<%themes%>}/tuto")
 */
class TutoController extends AbstractController
{

	const MAX_PER_PAGE = 4;

	/**
	 * @param string $theme
	 * @param ManagerRegistry $doctrine
	 * @param int $page
	 * @return Response
	 * @Route("/{page<d+>}", name="tutos")
	 */
	public function filterIndex(string $theme, ManagerRegistry $doctrine, int $page = 1): Response
	{
		$em = $doctrine->getManager();

		$tutoRepository = $em->getRepository(Tuto::class);
		$tutos = $tutoRepository->getByPage($page, self::MAX_PER_PAGE);
		$archive = $tutoRepository->getAllOrderByDate();

		$total = count($tutos);
		$maxPage = (int)($total / self::MAX_PER_PAGE);
		if (($total % self::MAX_PER_PAGE) !== 0) {
			$maxPage++;
		}
		return $this->render('front/tutos.html.twig', array(
			'maxPage' => $maxPage,
			'tutos' => $tutos,
			'page' => $page,
			'archive' => $archive,
			'theme' => $theme
		));
	}

	/**
	 * @return void
	 * @route("/test",name = "test")
	 */
	public function testTuto(string $theme): Response
	{
		return $this->render('front/testTuto.html.twig');
	}
}
