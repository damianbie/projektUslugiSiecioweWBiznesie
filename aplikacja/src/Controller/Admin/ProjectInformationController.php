<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Core\BaseAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectInformationController extends BaseAdminController
{
    public function index(): Response
    {
        return $this->render('admin/project_information/index.html.twig', [
            'active_nav_route' => 'app_information',
            'content_title' => '',
        ]);
    }
}
