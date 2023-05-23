<?php

namespace App\Repository;

use App\Entity\Tamagosaurus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tamagosaurus>
 *
 * @method Tamagosaurus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tamagosaurus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tamagosaurus[]    findAll()
 * @method Tamagosaurus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TamagosaurusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tamagosaurus::class);
    }

    public function save(Tamagosaurus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tamagosaurus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Tamagosaurus[] Returns an array of Tamagosaurus objects
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

//    public function findOneBySomeField($value): ?Tamagosaurus
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
