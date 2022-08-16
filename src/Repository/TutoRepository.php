<?php

namespace App\Repository;

use App\Entity\Tuto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tuto>
 *
 * @method Tuto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tuto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tuto[]    findAll()
 * @method Tuto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutoRepository extends ServiceEntityRepository
{
	const MAX_RESULT = 4;
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Tuto::class);
	}

	public function add(Tuto $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(Tuto $entity, bool $flush = false): void
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
		$query = $this->createQueryBuilder('t')
			->orderBy('t.date', 'DESC')
			->where('t.published = 1')
			->setFirstResult($offset)
			->setMaxResults($itemPerPage);
		return new Paginator($query);
	}

	public function getAllOrderByDate(): Paginator
	{
		$query = $this->createQueryBuilder('t')
			->orderBy('t.date', 'DESC')
			->where('t.published = 1');

		return new Paginator($query);
	}

//    /**
//     * @return Tuto[] Returns an array of Tuto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tuto
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
