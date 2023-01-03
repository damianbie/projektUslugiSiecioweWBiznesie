<?php

namespace App\Repository;

use App\Data\StateOfService;
use App\Entity\RepairOrder;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepairOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepairOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepairOrder[]    findAll()
 * @method RepairOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepairOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepairOrder::class);
    }

    // /**
    //  * @return RepairOrder[] Returns an array of RepairOrder objects
    //  */
    public function getCostAndIncomInMonth($start, $end)
    {
        $r = $this->createQueryBuilder('r')
            ->select("sum(s.service_cost) as cost, sum(s.price_netto + (s.tax * s.price_netto * 0.01)) as income_brutto, sum(s.tax * s.price_netto * 0.01) as tax")
            ->innerJoin("r.services", "s")
            ->where("r.orderedAt BETWEEN :st AND :end")
            ->setParameter("st", $start->format("Y-m-d"))
            ->setParameter("end", $end->format("Y-m-d"))
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $r;
    }

    public function getOrdersInMonth($start, $end)
    {
        $q = $this->createQueryBuilder('r')
        ->select("COUNT(r.id) as allOrders")
        ->where("r.orderedAt BETWEEN :st AND :end")
        ->setParameter("st", $start->format("Y-m-d"))
        ->setParameter("end", $end->format("Y-m-d"))
        ->getQuery()
        ->getOneOrNullResult();

        $q2 = $this->createQueryBuilder('r')
        ->select("COUNT(r.id) as notCompletedOrders")
        ->where("r.orderedAt BETWEEN :st AND :end")
        ->andWhere("r.endDate IS NULL")
        ->setParameter("st", $start->format("Y-m-d"))
        ->setParameter("end", $end->format("Y-m-d"))
        ->getQuery()
        ->getOneOrNullResult();

        return array_merge($q, $q2);

    }
    public function getServicesWithoutWorker()
    {
        $q = $this->createQueryBuilder('r')
            ->select("s.state, s.name")
            ->leftJoin("r.services", "s")
            ->join("s.madeBy", "wo")
            // ->groupBy("s")
            ->where("s.state != :state1 AND s.state != :state2")
            ->setParameter("state1", StateOfService::states()["zakończono"])
            ->setParameter("state2", StateOfService::states()["przerwano"])
            // ->andWhere("COUNT(s.madeBy) = 0")
            ->getQuery()
            ->getResult();

        dd($q);
        return $data;
    }

    /*
    public function findOneBySomeField($value): ?RepairOrder
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
