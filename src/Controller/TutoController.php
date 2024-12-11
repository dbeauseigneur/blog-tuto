<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Tuto;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Category controller.
 */
#[Route ('/{theme<%themes%>}/tuto')]

class TutoController extends AbstractController
{
	private const MAX_PER_PAGE = 4;

	#[Route('/{page<d+>}', name: 'tutos')]
	/**
	 * @param string $theme
	 * @param ManagerRegistry $doctrine
	 * @param int $page
	 * @return Response
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

	#[Route(path: '/test', name: 'test')]
	/**
	 * @param ManagerRegistry $doctrine
	 * @param string $theme
	 * @return Response
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

	#[Route('/install, name: install')]
	/**
	 * @param ManagerRegistry $doctrine
	 * @param string $theme
	 * @return Response
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

	#[Route('/geotiff-data', name: 'geotiffData')]
	/**
	 * @param ManagerRegistry $doctrine
	 * @param string $theme
	 * @return Response
	 */
	public function geotiffData(ManagerRegistry $doctrine, string $theme): Response
	{
		$em = $doctrine->getManager();
		$tuto = $em->getRepository(Tuto::class)->findOneBy(['url' => 'install']);
		return $this->render('front/geotiffData.html.twig', [
			'theme' => $theme,
			'tuto' => $tuto
		]);
	}


}
