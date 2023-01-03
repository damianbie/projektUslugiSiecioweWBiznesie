<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Core\BaseAdminController;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends BaseAdminController
{
    public function index(): Response
    {
        $mn = $this->getDoctrine()->getRepository(Vehicle::class);
        $vehicles = $mn->findAll();

        return $this->renderForm("admin/vehicle/index.html.twig", [
            'active_nav_route'  => 'admin_vehicles',
            'content_title'     => '',
            'vehicles'          => $vehicles,
        ]);
    }

    public function add(Request $req)
    {
        $vehicle =  $this->createForm(VehicleType::class);
        $vehicle->handleRequest($req);

        if($vehicle->isSubmitted() && $vehicle->isValid())
        {
            $v = $vehicle->getData();

            $mng = $this->getDoctrine()->getManager();
            $mng->persist($v);
            $mng->flush();

            $this->addFlash('msg', sprintf("Dodano pojazd do bazy id:%d", $v->getID()));
            $this->addFlash('successForm', 1);
            return $this->redirectToRoute('admin_vehicles');
        }
        else if($vehicle->isSubmitted())
        {
            $this->addFlash('msg', "Wystąpił nieoczekiwany błąd!!");
            $this->addFlash('successForm', 0);
        }


        return $this->renderForm("admin/vehicle/addVehicle.html.twig", [
            'active_nav_route'  => 'admin_vehicles_add',
            'content_title'     => '',
            'vehicle'           => $vehicle,
        ]);
    }
}
