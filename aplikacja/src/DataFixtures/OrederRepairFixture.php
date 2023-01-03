<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\RepairOrder;
use App\Entity\Serivce;
use App\Entity\Vehicle;
use App\Entity\Worker;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrederRepairFixture extends Fixture implements DependentFixtureInterface
{
    private $_faker = null;
    public function __construct()
    {
        $this->_faker = Factory::create('pl_PL');
    }
    public function randomDateInRange(\DateTime $start, \DateTime $end) {
        $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
        $randomDate = new \DateTimeImmutable();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }
    public function load(ObjectManager $manager): void
    {
        $this->load2($manager);
        return;

        $taxes = [8, 23];
        $cl = $manager->getRepository(Client::class)->findAll();
        $vw = $manager->getRepository(Vehicle::class)->findAll();
        $pr = $manager->getRepository(Worker::class)->findAll();

        foreach ($cl as $c)
        {
            $order = new RepairOrder();
            $order->setClient($c);
            $order->setVehicle($vw[array_rand($vw)]);
            $order->setOrderedAt(\DateTimeImmutable::createFromMutable($this->_faker->dateTime));
            if(rand(0, 100) > 10)
                $order->setEndDate(\DateTimeImmutable::createFromMutable($this->_faker->dateTime));
            $order->setAdditionalInfo($this->_faker->realText());
            $order->setAdditionalInfoPriv($this->_faker->realText());
            $order->setClientCode(dechex(random_int(100000, 100000000)));
            $order->setRegisteredBy($pr[array_rand($pr)]);

            $num = random_int(1, 5);
            for ($i = 0; $i < $num; $i += 1)
            {
                $serv = new Serivce();
                $serv->setName($this->_faker->text(20));
                $serv->setDescription($this->_faker->text());
                $serv->setPriceNetto(random_int(200, 4000));
                $serv->setTax($taxes[array_rand($taxes)]);

                $num2 = random_int(1, 3);
                for ($ii = 0; $ii < $num2; $ii += 1)
                    $serv->addMadeBy($pr[array_rand($pr)]);

                if($order->getEndDate() == null)
                    $serv->setState(random_int(1, 5));
                else
                    $serv->setState(3);

                $serv->setRepairOrder($order);
                $manager->persist($serv);
            }
            $manager->persist($order);
        }
        $manager->flush();
    }

    public function load2(ObjectManager $manager): void
    {
        ini_set('memory_limit', '-1');
        $nowDate = (new \DateTime())->getTimeStamp();
        $orderIsEnded = false;

        $taxes = [8, 23];
        $cl = $manager->getRepository(Client::class)->findAll();
        $vw = $manager->getRepository(Vehicle::class)->findAll();
        $pr = $manager->getRepository(Worker::class)->findAll();

        for ($i = 0; $i < 4 * 12; $i++)
        {
            for($j = 30; $j > 1;)
            {
                $days = rand(1, 3);
                $nowDate -= $days * 24 * 60 * 60;
                $orderDate = new DateTime(); $orderDate->setTimestamp($nowDate);

                $numOfOrders = rand(1, 5);
                for($numOrd = 0; $numOrd < $numOfOrders; $numOrd++)
                {
                    $orderDate->modify("-".rand(0, 2)." hours");
                    $order = new RepairOrder();
                    $order->setClient($cl[array_rand($cl)]);
                    $order->setVehicle($vw[array_rand($vw)]);
                    
                    $order->setOrderedAt(\DateTimeImmutable::createFromMutable($orderDate));
                    if($orderIsEnded)
                    {
                        $orderDate->modify("+".rand(1, 10)." day");
                        $order->setEndDate(\DateTimeImmutable::createFromMutable($orderDate));
                    }
                    $order->setAdditionalInfo($this->_faker->realText());
                    $order->setAdditionalInfoPriv($this->_faker->realText());
                    $order->setClientCode(dechex(random_int(100000, 100000000)));
                    $order->setRegisteredBy($pr[array_rand($pr)]);
        
                    $num = random_int(2, 10);
                    for ($ii = 0; $ii < $num; $ii += 1)
                    {
                        $proiceNetto = random_int(200, 4000);
                        $serv = new Serivce();
                        $serv->setName($this->_faker->text(20));
                        $serv->setDescription($this->_faker->text());
                        $serv->setPriceNetto($proiceNetto);
                        $serv->setTax($taxes[array_rand($taxes)]);
                        $serv->setServiceCost(rand(0.1 * $proiceNetto, 1.2 * $proiceNetto));

                        if(!$orderIsEnded)
                            $num2 = random_int(0, 3);
                        else     
                            $num2 = random_int(1, 3);

                        for ($ii2 = 0; $ii2 < $num2; $ii2 += 1)
                            $serv->addMadeBy($pr[array_rand($pr)]);

                        if($order->getEndDate() == null)
                            $serv->setState(random_int(1, 5));
                        else
                            $serv->setState(3);

                        $serv->setRepairOrder($order);
                        $manager->persist($serv);
                    }
                    $manager->persist($order);
                }

                if($i > 0 && $j > 7) $orderIsEnded = true;

                $j -= $days;
            }
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @psalm-return array<class-string<FixtureInterface>>
     */
    public function getDependencies()
    {
        return [
          ClientFixtures::class,
          VehicleFixtures::class
        ];
    }
}
