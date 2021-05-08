<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserGroup;
use App\Models\ClientsModel;
use App\Models\CompaniesModel;
use App\Models\ClientsVisitsModel;
use App\Libraries\AuthLib;

class Dashboard extends BaseController
{


    function __construct()
    {
        $loginLib = new AuthLib();
        $session = session();
        if (!$loginLib->isManager() AND !$loginLib->isAdmin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $userModel = new UserModel();
        $userGroupModel = new UserGroup();
        $CompaniesModel = new CompaniesModel();
        $GLOBALS['user'] =  $userModel->GetUser($session->get('user')['id']);
        $GLOBALS['user']['permission'] =  $userGroupModel->GetUserPermission($GLOBALS['user']['group']);
        $GLOBALS['user']['companies'] =  $CompaniesModel->find($GLOBALS['user']['companies_id']);
    }


    public function index()
    {
        $loginLib = new AuthLib();
        if($loginLib->isAdmin()){
            $CompaniesModel = new CompaniesModel();
            $Companies = $CompaniesModel->where('hide !=', 1)->find();
        }


        return view('profile/dashboard_view', [
            'title' => 'Личный кабинет',
            'companies' => $Companies,
            'admin' => (($loginLib->isAdmin())?true:false)
        ]);
    }

    public function get_statistic()
    {
        $msg = $params = $genders = [];
        $msg['success'] = false;
        $ClientsModel = new ClientsModel();
        $ClientsVisitsModel = new ClientsVisitsModel();

        if(isset($_POST['formattedDate'])){
            $dateArray = explode(' - ', $_POST['formattedDate']);
            $params['from_date'] = $dateArray[0];
            $params['to_date'] = $dateArray[1];
        }
        if(isset($_POST['companies_id'])){
            $params['companies_id'] = $_POST['companies_id'];
        }
        $msg['params'] = $params;

        $allVisites  = $ClientsVisitsModel->getVisites($params);
        $visites = $ClientsVisitsModel->getStatisticVisits($allVisites);
        $genders = $ClientsModel->getStatisticGenders($allVisites);
        $attendance = $ClientsModel->getStatisticAttendance($allVisites);


        if($visites){
            $msg['visites'] = $visites;
            $msg['genders'] = $genders;
            $msg['attendance'] = $attendance;
            $msg['success'] = true;
        } else {
            $msg['mess'] = 'Визитов не найдено';
        }

        return $this->response->setJSON($msg);
    }

    public function updateVisites()
    {
        $ClientsVisitsModel = new ClientsVisitsModel();
        $ClientsModel = new ClientsModel();

        $visites = $ClientsVisitsModel->find();
        foreach ($visites as $key => $value) {
            $client = $ClientsModel->find($value['clients_id']);
            $ClientsVisitsModel->update($value['id'], ['companies_id'=>$client['companies_id'], 'create_at'=>'202'.rand(0,1).'-0'.rand(1,9).'-0'.rand(1,9).' 00:00:00']);
        }
    }

    public function updateClients()
    {
        $ClientsModel = new ClientsModel();
        $clients = $ClientsModel->find();
        foreach ($clients as $key => $value) {
            $ClientsModel->update($value['id'], ['sex'=>rand(0,2)]);
        }

    }

}
