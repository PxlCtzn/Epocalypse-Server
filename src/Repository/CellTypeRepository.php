<?php

namespace App\Repository;

use App\Entity\CellType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Biome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Biome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Biome[]    findAll()
 * @method Biome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CellTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CellType::class);
    }

//    /**
//     * @return Biome[] Returns an array of Biome objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Biome
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
