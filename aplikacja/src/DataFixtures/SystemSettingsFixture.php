<?php

namespace App\DataFixtures;

use App\Entity\SystemSettings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SystemSettingsFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct()
    {
    }
    private function createSet(ObjectManager $man, $key, $da)
    {
        $s = new SystemSettings();
        $s->setName($key);
        $s->setData($da);
        $man->persist($s);
    }

    public function load(ObjectManager $manager): void
    {
        $this->createSet($manager, "appName", "bazaDB");
        $this->createSet($manager, "companyName", "mojaFirma");

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ClientFixtures::class,
            VehicleFixtures::class
        ];
    }
}
