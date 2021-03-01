<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\Admin\UsersAdminModel;
use App\Models\AddressModel;
use App\Libraries\AuthLib;

class Profile extends BaseController
{


    function __construct()
    {
        $loginLib = new AuthLib();
        if (!$loginLib->isLogin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }


    public function profile()
    {

        $loginLib = new AuthLib();
        $addressModel = new AddressModel();
        $session = session();

        if($loginLib->isAdmin()){
            $user = new UsersAdminModel();
            $user_item = $user->GetUser($session->get('user')['id']);
        } else {
            $user = new UserModel();
            $user_item = $user->GetUser($session->get('user')['id']);
        }

        return view('profile/profile', [
            'title' => 'Личный кабинет',
            'user_item' => $user_item,
            'address_list' => $addressModel->listLast($session->get('user')['id'], 999),
        ]);
    }

    /* Save info profile */
    public function info_ajax()
    {
        $session_user = session()->get('user');
        $email = $this->request->getVar('email');
        $email_current = $session_user['email'];

        if($session_user['group'] == 2){
            $user = new UserModel();
            $prefix = 'users';
        } else {
            $user = new UsersAdminModel();
            $prefix = 'users_main';
        }

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();
            $rules = [
                'surname' => 'required|max_length[50]',
                'name' => 'required|max_length[50]',
                'patronymic' => 'required|max_length[50]',
            ];

            if($email !== $session_user['email']){
                $rules['email'] = 'required|min_length[6]|max_length[50]|valid_email|is_unique['.$prefix.'.email]';
            }

            if (!$this->validate($rules)){
                $data_errors['validation'] = $validation->getErrors();
                return $this->response->setJSON($data_errors);
            } else {
                $newData = [
                    'name' => $this->request->getVar('name'),
                    'surname' => $this->request->getVar('surname'),
                    'patronymic' => $this->request->getVar('patronymic'),
                    'email' => $email,
                ];
                $user->update($session_user['id'], $newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

    }

    /* Save password */
    public function password_ajax()
    {   
        $session = session();
        $session_user = $session->get('user');
        $validation =  \Config\Services::validation();
        $loginLib = new AuthLib();

        if($session_user['group'] == 2){
            $user = new UserModel();
            $update = 'updateUser';
        } else {
            $user = new UsersAdminModel();
            $update = 'updateAdmin';
        }

        if ($this->request->getMethod() == 'post'){
            $rules = [
                'password' => 'required|min_length[4]|max_length[50]|' . $update . '[password]',
            ];
            if (!$this->validate($rules)){
                $data_errors['validation'] = $validation->getErrors();
                return $this->response->setJSON($data_errors);
            } else {
                $rules_new = [
                    'new_password' => 'required|min_length[4]|max_length[50]',
                    'new_password_confirm' => 'matches[new_password]',
                ];
                if (!$this->validate($rules_new)){
                    $data_errors['validation'] = $validation->getErrors();
                    return $this->response->setJSON($data_errors);
                } else {

                    $newData = [
                        'password' => $this->request->getVar('new_password'),
                    ];
                    $user->update($session_user['id'], $newData);

                    $data_errors['success'] = true;
                    $loginLib->setUserSession(false);

                    $session->setFlashdata('success', 'Вы успешно сменили пароль');

                    return $this->response->setJSON($data_errors);
                }
            }
        }

    }

}
