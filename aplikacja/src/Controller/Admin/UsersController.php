<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Core\BaseAdminController;
use App\Entity\User;
use App\Form\AddEditUserType;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use App\Services\AccountManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends BaseAdminController
{
    public $ac = null;
    public function __construct(AccountManager $_ac)
    {
        $this->ac = $_ac;
    }

    public function index(): Response
    {
        $usrRep = $this->getDoctrine()->getRepository(User::class);

        return $this->renderForm("admin/users/index.html.twig", [
            'active_nav_route'  => 'admin_user_index',
            'content_title'     => '',
            'users'             => $usrRep->findAll()
        ]);
    }


    public function addUser(Request $request)
    {
        $usr = new User();
        $form = $this->createForm(AddEditUserType::class, $usr);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $usr = $form->getData();
            $this->ac->createUser($usr);

            $this->addFlash('msg', sprintf("Utworzono nowe konto  %s (id: %d) ", $usr->getEmail(), $usr->getID()));
            $this->addFlash('successForm', 1);

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->renderForm("admin/users/addUser.html.twig", [
            'active_nav_route'  => 'admin_user_add',
            'content_title'     => '',
            'form'              => $form
        ]);
    }
    public function editUser(Request $request, User $usr)
    {
        $form = $this->createForm(EditUserType::class, $usr);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $usr = $form->getData();
            $usr = $this->ac->updatePass($usr);

            $mng = $this->getDoctrine()->getManager();
            $mng->persist($usr);
            $mng->flush();

            $this->addFlash('msg', sprintf("Zapisano zmiany dla %s (id: %d) ", $usr->getEmail(), $usr->getID()));
            $this->addFlash('successForm', 1);

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->renderForm("admin/users/addUser.html.twig", [
            'active_nav_route'  => 'admin_user_add',
            'content_title'     => '',
            'form'              => $form
        ]);
    }

    public function enableUser(User $usr)
    {
        $usr->setActive(true);
        $mn = $this->getDoctrine()->getManager();
        $mn->persist($usr);
        $mn->flush();
        return $this->redirectToRoute('admin_user_index');
    }

    public function disableUser(User $usr)
    {
        $usr->setActive(false);
        $mn = $this->getDoctrine()->getManager();
        $mn->persist($usr);
        $mn->flush();

        return $this->redirectToRoute('admin_user_index');
    }
}
