<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Category;
use mysql_xdevapi\Result;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
	const MAX_RESULT = 4;

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Post::class);
	}

	public function add(Post $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(Post $entity, bool $flush = false): void
	{
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function getByPage(int $page, int $itemPerPage = self::MAX_RESULT): Paginator
	{
		if ($page > 0) {
			$offset = ($page - 1) * $itemPerPage;
		} else {
			$offset = 0;
		}
		$query = $this->createQueryBuilder('p')
			->orderBy('p.publicationDate', 'DESC')
			->where('p.status = 1')
			->setFirstResult($offset)
			->setMaxResults($itemPerPage);
		return new Paginator($query);
	}

	public function categoryGetByPage(Category $category, int $page, int $itemPerPage = self::MAX_RESULT): paginator
	{
		if ($page > 0) {
			$offset = ($page - 1) * $itemPerPage;
		} else {
			$offset = 0;
		}
		$query = $this->createQueryBuilder('p')
			->innerJoin('p.categories', 'c')
			->where('c.id = ?1')
			->orderBy('p.publicationDate', 'DESC')
			->setParameter(1, $category->getId())
			->andWhere('p.status = 1')
			->setFirstResult($offset)
			->setMaxResults($itemPerPage);
		return new Paginator($query);
	}

	/**
	 * @param $limit
	 * @return array
	 */
	public function getLastSixArticles(int $limit): array
	{
		$carouselArticles = $this->createQueryBuilder('la')
			->orderBy('la.id', 'DESC')
			->where('la.status = 1')
			->setMaxResults($limit)
			->getQuery();
		return $carouselArticles->getResult();
	}


	public function getAllOrderByDate(): Paginator
	{
		$query = $this->createQueryBuilder('p')
			->orderBy('p.publicationDate', 'DESC')
			->where('p.status = 1');

		return new Paginator($query);
	}

	public function getComments(): array
	{
		$comments = $this->createQueryBuilder('co')
			->orderBy('co.id', 'DESC')
			->getQuery();
		return $comments->getResult();

	}
//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
