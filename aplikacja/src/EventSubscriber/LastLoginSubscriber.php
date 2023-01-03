<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LastLoginSubscriber implements EventSubscriberInterface
{
    private $_man;
    public function __construct(EntityManagerInterface  $man)
    {
        $this->_man = $man;
    }

    public function onSecutiryAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $now = new \DateTime('now');
        $usr =  $event->getAuthenticationToken()->getUser();
        $usr->setLastLoggedIn($now);

        $this->_man->persist($usr);
        $this->_man->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.authentication.success' => 'onSecutiryAuthenticationSuccess',
        ];
    }
}
