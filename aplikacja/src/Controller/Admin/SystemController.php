<?php
namespace App\Controller\Admin;

use App\Controller\Admin\Core\BaseAdminController;
use App\Entity\SystemSettings;
use App\Form\SystemSettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SystemController extends BaseAdminController
{
    public static $keys = ['appName' => 'Nazwa aplikacj', 'companyName' => 'Nazwa firmy'];

    public function __construct()
    {
        
    }

    public function index(Request $req): Response
    {
        $sysForm = $this->createForm(SystemSettingsType::class);
        $sysForm->handleRequest($req);

        $mng = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(SystemSettings::class);
        if($sysForm->isSubmitted() && $sysForm->isValid())
        {
            // $worker = $sysForm->getData();
            // $mng = $this->getDoctrine()->getManager();
            $data = $sysForm->getNormData();
            
            foreach ($data as $key => $v) {
                $s = $repo->findByKey($key);
                $s->setData($v);
                $mng->persist($s);
            }
            
            $mng->flush();

            $this->addFlash('msg', "Zapisano dane");
            $this->addFlash('successForm', 1);

            return $this->redirectToRoute('admin_sys_settings');
        }
        else if($sysForm->isSubmitted())
        {
            $this->addFlash('successForm', 0);
            $this->addFlash('msg', "Blad przy edytowaniu danych");
            return $this->redirectToRoute('admin_sys_settings');
        }

        return $this->renderForm("admin/system/index.html.twig", [
            'active_nav_route'  => 'admin_sys_settings',
            'content_title'     => '',
            'systemForm'        => $sysForm,
        ]);
    }
}
