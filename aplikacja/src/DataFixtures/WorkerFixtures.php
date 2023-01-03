<?php
namespace App\DataFixtures;

use App\Entity\Worker;
use App\Services\AccountManager;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WorkerFixtures extends Fixture
{
    public const ADMIN_USER = "admin-user";

    public $_faker;
    public $_acManager;

    public function __construct(AccountManager $am)
    {
        $this->_faker       = Factory::create('pl_PL');
        $this->_acManager   = $am;
    }

    private function _createWorker(array $data): Worker
    {
        $worker = new Worker();
        $worker->setName($data['name']);
        $worker->setSurname($data['surname']);
        $worker->setBirthDate($data['birthDate']);
        $worker->setWorkPlace($data['workPlace']);
        $worker->setHiredAt($data['hiredAt']);
        $worker->setPhoneNumber($this->_faker->phoneNumber());

        return $worker;
    }

    public function load(ObjectManager $manager): void
    {
        $worker = $this->_createWorker(array(
            'name' => 'Damian',
            'surname' => 'Bielecki',
            'birthDate' => new \DateTime('now'),
            'workPlace' => $this->getReference(WorkPlaceFixtures::WORKPLACE_BOSS),
            'hiredAt' => new \DateTimeImmutable('now'),
        ));
        $manager->persist($worker);

        $worker2 = $this->_createWorker(array(
            'name' => 'Mariusz',
            'surname' => 'Borkowski',
            'birthDate' => new \DateTime('now'),
            'workPlace' => $this->getReference(WorkPlaceFixtures::WORKPLACE_BOSS),
            'hiredAt' => new \DateTimeImmutable('now'),
        ));
        $manager->persist($worker2);

        $u = new User();
        $u->setEmail('damian@test.com');
        $u->setPassword('admin');
        $u->setActive(true);
        $u->setWorker($worker);
        $u->setRoles(['ROLE_ADMIN']);
        $this->_acManager->createUser($u);

        $u2 = new User();
        $u2->setEmail('marbor@test.pl');
        $u2->setPassword('marbor');
        $u2->setActive(true);
        $u2->setWorker($worker2);
        $u2->setRoles(['ROLE_ADMIN']);
        $this->_acManager->createUser($u2);


        for ($i = 0; $i < 5; $i += 1) {
            $worker1 = $this->_createWorker(array(
                'name' => $this->_faker->firstName,
                'surname' => $this->_faker->lastName,
                'birthDate' => $this->_faker->dateTime($max = 'now'),
                'workPlace' => $this->getReference(WorkPlaceFixtures::WORKPLACE_MECHANIC),
                'hiredAt' => \DateTimeImmutable::createFromMutable($this->_faker->dateTime($max = 'now')),
            ));
            $manager->persist($worker1);
            //$ps = $this->_faker->password;
            //$this->_acManager->createUser($worker1, $this->_faker->email,'admin');
            //dump($ps);
        }
        $manager->flush();
    }
}