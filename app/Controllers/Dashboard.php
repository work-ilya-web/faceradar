<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserGroup;
use App\Models\CompaniesModel;
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
        return view('profile/dashboard_view', [
            'title' => 'Личный кабинет'
        ]);
    }



}
