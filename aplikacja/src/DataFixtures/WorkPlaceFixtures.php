<?php

namespace App\DataFixtures;

use App\Entity\WorkPlace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WorkPlaceFixtures extends Fixture implements FixtureGroupInterface
{
    public const WORKPLACE_BOSS         = "workplace-boss";
    public const WORKPLACE_MECHANIC     = "workplace-mechanic";

    private $_faker;
    public function __construct()
    {
        $this->_faker = Factory::create('pl_PL');
    }

    public function load(ObjectManager $manager): void
    {
        $workPlace1 = new WorkPlace();
        $workPlace1->setName('Szef');
        $workPlace1->setMinEarnings(1000);
        $workPlace1->setDescription($this->_faker->text);

        $workPlace2 = new WorkPlace();
        $workPlace2->setName('mechanik');
        $workPlace2->setMinEarnings(200);
        $workPlace2->setDescription($this->_faker->text);

        $manager->persist($workPlace1);
        $manager->persist($workPlace2);
        $manager->flush();

        $this->setReference(self::WORKPLACE_BOSS, $workPlace1);
        $this->setReference(self::WORKPLACE_MECHANIC, $workPlace2);
    }
    public static function getGroups(): array
    {
        return ['workPlace'];
    }
}
