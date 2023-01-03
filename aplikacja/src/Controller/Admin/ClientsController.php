<?php
namespace App\Controller\Admin;

use App\Controller\Admin\Core\BaseAdminController;
use App\Entity\Address;
use App\Form\AddressType;
use App\Form\CClientType;
use App\Form\PClientType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Client;

class ClientsController extends BaseAdminController
{
    public function index(): Response
    {
        $repositorty    = $this->getDoctrine()->getRepository(Client::class);
        $companies      = $repositorty->findAllCompanies();
        $clients        = $repositorty->findAllClients();


        return $this->render('admin/clients/index.html.twig', [
            'active_nav_route'  => 'admin_clients',
            'content_title'     => '',
            'clients'           => $clients,
            'companies'         => $companies,
        ]);
    }

    public function add(Request $request): Response
    {
        $pForm = $this->createForm(PClientType::class);
        $cForm = $this->createForm(CClientType::class);
        $pForm->handleRequest($request);
        $cForm->handleRequest($request);

        $mng = $this->getDoctrine()->getManager();
        if($pForm->isSubmitted() && $pForm->isValid())
        {
            $client = $pForm->getData();
            $add = $pForm->get('address')->getData();
            $client->setIsCompany(false);
            $client->setAddedAt(new \DateTimeImmutable('now'));
            $client->setCorrespondenceAddress($add);

            $mng->persist($add);
            $mng->persist($client);
            $mng->flush();

            $this->addFlash('successForm', 1);
            $this->addFlash('msg', sprintf("Utworzono klienta %s(id: %d)", $client->getName(), $client->getId()));
            return $this->redirect($request->getUri());
        }

        if($cForm->isSubmitted() && $cForm->isValid())
        {
            $client = $cForm->getData();
            $add = $cForm->get('address')->getData();
            $client->setIsCompany(true);
            $client->setAddedAt(new \DateTimeImmutable('now'));
            $client->setCorrespondenceAddress($add);

            $mng->persist($add);
            $mng->persist($client);
            $mng->flush();

            $this->addFlash('successForm', 1);
            $this->addFlash('msg', sprintf("Utworzono klienta %s(id: %d)", $client->getName(), $client->getId()));
            return $this->redirect($request->getUri());
        }

        if($cForm->isSubmitted() && $pForm->isSubmitted()
        && !$cForm->isValid() && !$pForm->isValid())
        {
            $this->addFlash('successForm', 0);
            $this->addFlash('msg', "Blad przy edytowaniu danych");
            return $this->redirect($request->getUri());
        }


        return $this->renderForm('admin/clients/addClient.html.twig', [
            'active_nav_route'  => 'admin_client_add',
            'content_title'     => '',
            'clients'           => $pForm,
            'companies'         => $cForm
        ]);
    }

    public function edit(Client $cl, Request $request)
    {
        if($cl->getIsCompany())
            $form = $this->createForm(CClientType::class ,$cl);
        else
            $form = $this->createForm(PClientType::class ,$cl);

        if($cl->getCorrespondenceAddress() != null)
            $form->get('address')->setData($cl->getCorrespondenceAddress());


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $mng = $this->getDoctrine()->getManager();
            $addr = $form->get('address')->getData();
            $c = $form->getData();
            $mng->persist($addr);
            if($c->getCorrespondenceAddress() == null) $c->setCorrespondenceAddress($addr);
            $mng->persist($c);
            $mng->flush();

            $this->addFlash('successForm', 1);
            $this->addFlash('msg', sprintf("Zaktuliowano klienta %s(id: %d)", $cl->getName(), $cl->getId()));
            return $this->redirectToRoute('admin_clients');
        }
        else if($form->isSubmitted())
        {
            $this->addFlash('successForm', 0);
            $this->addFlash('msg', sprintf("Blad podczas edycji klienta %s(id: %d)", $cl->getName(), $cl->getId()));

            return $this->redirectToRoute('admin_clients');
        }

        return $this->renderForm('admin/clients/editClient.html.twig', [
            'active_nav_route'  => 'admin_client_edit',
            'content_title'     => '',
            'form'              => $form
        ]);
    }
    public function detalis(Client $cl, Request $request)
    {
        if($cl->getIsCompany())
            $form = $this->createForm(CClientType::class ,$cl, ['disabled' => true]);
        else
            $form = $this->createForm(PClientType::class ,$cl, ['disabled' => true]);

        $form->get('address')->setData($cl->getCorrespondenceAddress());
        return $this->renderForm('admin/clients/editClient.html.twig', [
            'active_nav_route'  => 'admin_client_detalis',
            'content_title'     => '',
            'form' => $form
        ]);
    }
    public function delete(Client $cl)
    {
        $name = $cl->getName();
        $id = $cl->getId();
        $mn = $this->getDoctrine()->getManager();

        //TODO: znajdz zlecenia jezeli tak to nie usuwaj
        $mn->remove($cl->getCorrespondenceAddress());
        $mn->remove($cl);
        $mn->flush();

        $this->addFlash('successForm', 1);
        $this->addFlash('msg', sprintf("Usunieto klienta %s(id: %d)", $name, $id));

        return $this->redirectToRoute('admin_clients');
    }
}