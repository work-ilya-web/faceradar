<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\AuthModel;
use App\Libraries\AuthLib;

class Auth extends BaseController {

    public function login_view()
    {
        return view('profile/admin/auth', [
            'title' => 'Войти',
            'success' => true
        ]);
    }

    public function login(){
        
        $userModel = new AuthModel();
        $loginLib = new AuthLib();
        $data = [];
        $data_errors = [];

        if ($this->request->getMethod() == 'post'){
            $validation =  \Config\Services::validation();

            $rules = [
                'phone' => 'required|min_length[6]|max_length[50]',
                'password' => 'required|min_length[4]|max_length[255]|validateAdmin[phone,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => "Телефон или пароль не верный",
                ],
            ];

            if (!$this->validate($rules, $errors)){
                $data_errors['validation'] = $validation->getErrors();
                return $this->response->setJSON($data_errors);
            } else {
                
                $user = $userModel->where('phone', $this->request->getVar('phone'))
                    ->first();

                $loginLib->setUserSession($user);
                return redirect()->to(base_url().'/profile');
            }
        }
    }

    public function logout(){       
        
        $loginLib = new AuthLib();
        $loginLib->setUserSession(false);

        return redirect()->to(base_url().'/admin/login');  
    }

}