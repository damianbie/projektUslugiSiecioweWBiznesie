<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Core\BaseAdminController;
use App\Entity\RepairOrder;
use App\Entity\Serivce;
use App\Services\AccountManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseAdminController
{
    public function index(): Response
    {
        $w = $this->getUser()->getWorker();
        $roRep = $this->getDoctrine()->getRepository(RepairOrder::class);
        $seRep = $this->getDoctrine()->getRepository(Serivce::class);

        $start = new \DateTime("2022-12-01");
        $end = new \DateTime("2023-01-01");
        
        $dataCostAndIncome = $roRep->getCostAndIncomInMonth($start, $end);
        $seWW = $seRep->getServicesWithoutWorker();
        $orders = $roRep->getOrdersInMonth($start, $end);

        $se = $w->getSerivces();
        $ss = [];
        foreach($se as $s) {
         switch ($s->getState())
         {
             case 1:
             case 2:
             case 4:
                $ss[] = $s;
                 break;
         }
        }

        return $this->render('admin/dashboard/index.html.twig', [
            'active_nav_route' => 'admin_dashboard',
            'content_title'     => '',
            'activeServices'    => $ss,
            'seWW'              => $seWW,
            'costAndIncome'     => $dataCostAndIncome,
            'orders'            => $orders,

        ]);
    }

    public function endSerive(Serivce $serivce)
    {
        $serivce->setState(3);
        $mng = $this->getDoctrine()->getManager();
        $mng->persist($serivce);
        $mng->flush($serivce);

        $this->addFlash('msg', sprintf("Zakończono usługę"));
        $this->addFlash('successForm', 1);

        return $this->redirectToRoute('admin_dashboard');
    }

    public function setMe(Serivce $serivce)
    {
        $w = $this->getUser()->getWorker();
        $serivce->addMadeBy($w);
        $mng = $this->getDoctrine()->getManager();
        $mng->persist($serivce);
        $mng->flush($serivce);

        $this->addFlash('msg', sprintf("Dodano do zadania!"));
        $this->addFlash('successForm', 1);

        return $this->redirectToRoute('admin_dashboard');
    }
}