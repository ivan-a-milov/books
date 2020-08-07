<?php

namespace App\Repository;

use App\Entity\Author;
use App\Repository\Domain\AuthorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @param string $authorName
     * @return Author|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName(string $authorName): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.name = :val')
            ->setParameter('val', $authorName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Author $author
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(Author $author)
    {
        $this->getEntityManager()->persist($author);
    }
}
