<?php


namespace App\Services;

use App\Entity\Worker;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountManager
{
    private $_entityManager     = null;
    private $_usrRep            = null;
    private $_passwordHasher   = null;

    public function __construct(EntityManagerInterface $mng, UserRepository $rep, UserPasswordHasherInterface $passwordHasher)
    {
        $this->_entityManager   = $mng;
        $this->_usrRep          = $rep;
        $this->_passwordHasher  = $passwordHasher;
    }
    public function hasUserAccount(Worker $worker)
    {
        return count($this->_usrRep->findBy(['worker' => $worker->getId()])) > 0;
    }
    public function enableWorkerAccount(Worker $w)
    {
        $usr = $w->getAccount();
        if($usr != null)
        {
            $usr->setActive(true);
        }
    }
    public function disableWorkerAccount(Worker $w)
    {
        $usr = $w->getAccount();
        if($usr != null)
        {
            $usr->setActive(false);
        }
    }
    public function createUser(User $user)
    {
        $user->setAccountCreatedAt(new \DateTimeImmutable('now'));
        $user->setPassword($this->_passwordHasher->hashPassword($user, $user->getPassword()));

        $this->_entityManager->persist($user);
        $this->_entityManager->flush();
    }
    public function updatePass(User $user):User
    {
        $user->setPassword($this->_passwordHasher->hashPassword($user, $user->getPassword()));
        return $user;
    }

    private function _getUser(Worker $w): User
    {
        $usr = $this->_usrRep->findBy(['worker' => $w->getId()]);
        if(count($usr) > 0)
            return $usr[0];
        else return null;
    }
}