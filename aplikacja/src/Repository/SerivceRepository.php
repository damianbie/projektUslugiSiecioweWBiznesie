<?php

namespace App\Repository;

use App\Data\StateOfService;
use App\Entity\Serivce;
use App\Entity\Worker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\ResultSetMappingBuilder;


/**
 * @method Serivce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serivce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serivce[]    findAll()
 * @method Serivce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerivceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serivce::class);
    }


    public function getServicesWithoutWorker()
    {
        $entityManager = $this->getEntityManager();
        $rsm = new ResultSetMappingBuilder($entityManager);
        $rsm->addRootEntityFromClassMetadata('App\\Entity\\Serivce', 's');
        $q = $this->getEntityManager()->createNativeQuery('SELECT s.id, s.repair_order_id, s.name, s.description, s.price_netto, s.tax, s.state, s.service_cost
        FROM repair_order ro 
        LEFT JOIN serivce s ON s.repair_order_id=ro.id
        LEFT JOIN serivce_worker sw ON s.id=sw.serivce_id
        LEFT JOIN worker w ON w.id=sw.worker_id
        WHERE s.state != 3 AND s.state != 5
        GROUP BY s.id
        HAVING COUNT(w.id)=0;', $rsm)
        ->getResult();

        return $q;
    }
    /*
    public function findOneBySomeField($value): ?Serivce
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
