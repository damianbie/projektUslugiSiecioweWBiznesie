<?php

namespace App\DataFixtures;

use App\Data\VehiclesData;
use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VehicleFixtures extends Fixture
{
    private $_faker = null;
    public function __construct()
    {
        $this->_faker = Factory::create('pl_PL');
    }

    public function load(ObjectManager $manager): void
    {
        $data = VehiclesData::data();
        for($i = 0; $i < 500; $i += 1)
        {
            $man = array_rand($data);

            $v = new Vehicle();
            $v->setManufacturer(($man));
            $v->setModel($data[$man][array_rand($data[$man])]);
            $v->setProductionYear(random_int(1990, 2022));
            $v->setVin(bin2hex(random_bytes(17/2)));
            $v->setRegistrationNumber( 'PL'.bin2hex(random_bytes(6/2)));

            $manager->persist($v);
        }
        $manager->flush();
    }
}
