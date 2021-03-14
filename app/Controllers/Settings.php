<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserGroup;
use App\Models\CompaniesModel;
use App\Libraries\AuthLib;

class Settings extends BaseController
{

    function __construct()
    {
        $loginLib = new AuthLib();
        $session = session();
        if (!$loginLib->isLogin()) {
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
        return view('profile/settings/'.$GLOBALS['user']['permission']['alias'].'/profile_view', [
            'title' => 'Личный кабинет'
        ]);
    }


    public function profile_admin_save_ajax()
    {

        if ($this->request->getMethod() == 'post') {
            $userModel = new UserModel();
            $validation =  \Config\Services::validation();
            $newEmail = $this->request->getVar('email');
            $rules = [
                'api' => 'required|max_length[100]',
                'name' => 'required|max_length[50]',
            ];

            if($newEmail !== $GLOBALS['user']['email']){
                $rules['email'] = 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]';
            }

            if (!$this->validate($rules)){
                $data_errors['validation'] = $validation->getErrors();
                return $this->response->setJSON($data_errors);
            } else {
                $newData = [
                    'name' => $this->request->getVar('name'),
                    'surname' => $this->request->getVar('surname'),
                    'api' => $this->request->getVar('api'),
                    'email' => $newEmail,
                ];
                $userModel->update($GLOBALS['user']['id'], $newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

    }


    public function edit_password_ajax()
    {
        $user = new UserModel();
        $validation =  \Config\Services::validation();

        if ($this->request->getMethod() == 'post'){
            $rules = [
                'password' => 'required|min_length[4]|max_length[50]|updateUser[password]',
            ];
            if (!$this->validate($rules)){
                $data_errors['validation'] = $validation->getErrors();
                return $this->response->setJSON($data_errors);
            } else {

                $newData = [
                    'password' => $this->request->getVar('password'),
                ];
                $user->update($GLOBALS['user']['id'], $newData);

                $data_errors['success'] = true;

                return $this->response->setJSON($data_errors);

            }
        }

    }

}
