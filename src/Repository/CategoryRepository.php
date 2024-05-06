<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Category::class);
	}

	public function add(Category $entity, bool $flush = false): void
	{
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(Category $entity, bool $flush = false): void
	{
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function deleteLink($object)
	{

		$conn = $this->_em->getConnection();
		$catId = $object->getId();

		$sql = "DELETE from posts_categorys where category_id = $catId";
		$stmt = $conn->prepare($sql);

		$stmt->execute();
	}

	public function addLink($object)
	{

		$conn = $this->_em->getConnection();
		$catId = $object->getId();

		foreach ($object->getPosts() as $post) {
			$postId = $post->getId();
			$sql = "INSERT into posts_categorys (post_id,category_id) VALUES ($postId,$catId)";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
	}

	public function getAllOrderByName()
	{
		$category = $this->createQueryBuilder('ca')
			->orderBy('ca.categoryName', 'ASC')
			->getQuery();
		return $category->getResult();
	}

	//    /**
	//     * @return Category[] Returns an array of Category objects
	//     */
	//    public function findByExampleField($value): array
	//    {
	//        return $this->createQueryBuilder('c')
	//            ->andWhere('c.exampleField = :val')
	//            ->setParameter('val', $value)
	//            ->orderBy('c.id', 'ASC')
	//            ->setMaxResults(10)
	//            ->getQuery()
	//            ->getResult()
	//        ;
	//    }

	//    public function findOneBySomeField($value): ?Category
	//    {
	//        return $this->createQueryBuilder('c')
	//            ->andWhere('c.exampleField = :val')
	//            ->setParameter('val', $value)
	//            ->getQuery()
	//            ->getOneOrNullResult()
	//        ;
	//    }
}
