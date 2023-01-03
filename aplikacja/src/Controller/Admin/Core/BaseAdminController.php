<?php
namespace App\Controller\Admin\Core;

use App\Entity\SystemSettings;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseAdminController extends AbstractController
{
    protected $_sysRepo = null;
    public function __construct()
    {
       // $this->isGranted('');
    }
    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $sideBarNav['admin_dashboard'] = array('icon' => 'fas fa-tachometer-alt', 'name' => 'Start');

        $sideBarNav['adminOrders'] = array('icon' => 'fas fa-clipboard-list', 'name' => 'Zlecenia', 'childs' => array(
            'admin_orders' => array('icon' => 'far fa-circle', 'name' => 'Przeglądaj'),
            'admin_order_add' => array('icon' => 'far fa-circle', 'name' => 'Dodaj nowe')
        ));

        $sideBarNav['adminClients'] = array('icon' => 'fas fa-user-tag', 'name' => 'Klienci', 'childs' => array(
            'admin_clients' => array('icon' => 'far fa-circle', 'name' => 'Przeglądaj'),
            'admin_client_add' => array('icon' => 'far fa-circle', 'name' => 'Dodaj')
        ));

        $sideBarNav['adminVehicles'] = array('icon' => 'fas fa-car', 'name' => 'Pojazdy', 'childs' => array(
            'admin_vehicles' => array('icon' => 'far fa-circle', 'name' => 'Przeglądaj'),
            'admin_vehicles_add' => array('icon' => 'far fa-circle', 'name' => 'Dodaj')
        ));

        $sideBarNav['adminWorkers'] = array('icon' => 'fas fa-user-tag', 'name' => 'Pracownicy', 'childs' => array(
            'admin_workers' => array('icon' => 'far fa-circle', 'name' => 'Profile i stanowiska'),
            'admin_workers_add' => array('icon' => 'far fa-circle', 'name' => 'Dodaj profil')
        ));

        $sideBarNav['system'] = array('icon' => 'fas fa-sliders-h', 'name' => 'System', 'childs' => array(
            'admin_sys_settings' => array('icon' => 'far fa-circle', 'name' => 'Ustawienia'),
            'admin_user_index' => array('icon' => 'far fa-circle', 'name' => 'Konta'),
            'admin_user_add' => array('icon' => 'far fa-circle', 'name' => 'Dodaj konto')
        ));

        $sideBarNav['app_information'] = array('icon' => 'fas fa-atom', 'name' => 'Informacje');
        $sideBarNav['app_logout'] = array('icon' => 'fas fa-sign-out-alt', 'name' => 'Wyloguj');

        $defaultParams['app_name'] = 'bazaDB';
        $defaultParams['app_name'] = $this->getK("appName");
        $defaultParams['sideBarNav'] = $sideBarNav;

        $parameters = array_merge($parameters, $defaultParams);
        return parent::render($view, $parameters, $response);
    }

    protected function getK($key, $def = '')
    {
        if($this->_sysRepo == null)
            $this->_sysRepo = $this->getDoctrine()->getRepository(SystemSettings::class);

        $d =  $this->_sysRepo->findByKey($key);
        if($d != null)
            return $d->getData();
        else 
            return $def;
    }
}