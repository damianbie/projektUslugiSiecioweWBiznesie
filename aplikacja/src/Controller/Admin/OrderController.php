<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Core\BaseAdminController;
use App\Entity\Serivce;
use App\Form\RepairOrderType;
use App\Repository\RepairOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RepairOrder;

class OrderController extends BaseAdminController
{

    public function index($id): Response
    {
        $repo = $this->getDoctrine()->getRepository(RepairOrder::class);
        $actualOrders   = $repo->findBy(['endDate' => null]);
        $allOrders      = $repo->findAll();

        return $this->render('admin/order/index.html.twig', [
            'active_nav_route'  => 'admin_orders',
            'content_title'     => 'Zlecenia napraw - przegląd',
            'actualOrders'      => $actualOrders,
            'allOrders'         => $allOrders,
        ]);
    }

    public function add(Request $req): Response
    {
        $form = $this->createForm(RepairOrderType::class);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $mng = $this->getDoctrine()->getManager();
            $wor = $this->getUser()->getWorker();

            $or = $form->getData();
            $or->setRegisteredBy($wor);
            $or->setOrderedAt(new \DateTimeImmutable('now'));
            $or->setClientCode(dechex(random_int(100000, 100000000)));
            $mng->persist($or);

            foreach ($form->get('services')->getData() as $val) {
                $val->setRepairOrder($or);
                $mng->persist($val);
            }

            $mng->flush();
            $this->addFlash('msg', sprintf("Utworzono nowe zlecenie "));
            $this->addFlash('successForm', 1);

            return $this->redirectToRoute('admin_orders');
        }

        return $this->renderForm('admin/order/addOrder.html.twig', [
            'active_nav_route' => 'admin_order_add',
            'content_title' => 'Tworzenie zlecenia',
            'form'          => $form
        ]);
    }
    public function edit(Request $req, RepairOrder $or): Response
    {
        $form = $this->createForm(RepairOrderType::class, $or);
        $r = $this->getDoctrine()->getRepository(Serivce::class);
        $d = $r->findBy(['repairOrder' => $or->getId()]);
        $form->get('services')->setData($d);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $mng = $this->getDoctrine()->getManager();
            $wor = $this->getUser()->getWorker();

            $or = $form->getData();
            $or->setRegisteredBy($wor);
            $or->setOrderedAt(new \DateTimeImmutable('now'));
            $or->setClientCode(dechex(random_int(100000, 100000000)));
            $mng->persist($or);

            foreach ($form->get('services')->getData() as $val) {
                $val->setRepairOrder($or);
                $mng->persist($val);
            }

            $mng->flush();
            $this->addFlash('msg', sprintf("Zaktualizowano zlecenie "));
            $this->addFlash('successForm', 1);

            return $this->redirectToRoute('admin_orders');
        }

        return $this->renderForm('admin/order/addOrder.html.twig', [
            'active_nav_route' => 'admin_order_add',
            'content_title' => 'Edycja zlecenia',
            'form'          => $form
        ]);
    }

    public function detalis(Request $req, RepairOrder $or): Response
    {
        $form = $this->createForm(RepairOrderType::class, $or, ['disabled' => true]);
        $r = $this->getDoctrine()->getRepository(Serivce::class);
        $d = $r->findBy(['repairOrder' => $or->getId()]);
        $form->get('services')->setData($d);

        return $this->renderForm('admin/order/addOrder.html.twig', [
            'active_nav_route' => 'admin_order_add',
            'content_title' => 'Szczegóły zlecenia',
            'form'          => $form
        ]);
    }

    public function end(Request $req, RepairOrder $or): Response
    {
        $r = $this->getDoctrine()->getRepository(Serivce::class);
        $d = $r->findBy(['repairOrder' => $or->getId()]);

        $ok = true;
        foreach ($d as $v)
        {
            if($v->getState() != 3 && $v->getState() != 5)
                $ok = false;
        }

        if($ok)
        {
            $or -> setEndDate(new \DateTimeImmutable('now'));
            $m = $this->getDoctrine()->getManager();
            $m->persist($or);
            $m->flush();

            $this->addFlash('msg', sprintf("Zamknięto zlecenie"));
            $this->addFlash('successForm', 1);
            return $this->redirectToRoute('admin_orders');
        }
        else
        {
            $this->addFlash('msg', sprintf("Najpierw zakończ wszystkie naprawy w zleceniu!"));
            $this->addFlash('successForm', 0);
            return $this->redirectToRoute('admin_orders');
        }
    }

}