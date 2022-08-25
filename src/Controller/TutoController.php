<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Tuto;

/**
 * Category controller.
 * @route("/{theme<%themes%>}/tuto")
 */
class TutoController extends AbstractController
{

	private const MAX_PER_PAGE = 4;

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
	 * @param ManagerRegistry $doctrine
	 * @param string $theme
	 * @return Response
	 * @route("/test",name = "test")
	 */
	public function testTuto(ManagerRegistry $doctrine, string $theme): Response
	{
		$em = $doctrine->getManager();
		$tuto = $em->getRepository(Tuto::class)->findOneBy(['url' => 'test']);
		return $this->render('front/testTuto.html.twig', [
			"theme" => $theme,
			"tuto" => $tuto
		]);
	}

	/**
	 * @param ManagerRegistry $doctrine
	 * @param string $theme
	 * @return Response
	 * @route("/install",name = "install")
	 */
	public function installTuto(ManagerRegistry $doctrine, string $theme): Response
	{
		$em = $doctrine->getManager();
		$tuto = $em->getRepository(Tuto::class)->findOneBy(['url' => 'install']);
		return $this->render('front/installTuto.html.twig', [
			'theme' => $theme,
			'tuto' => $tuto
		]);
	}
}
