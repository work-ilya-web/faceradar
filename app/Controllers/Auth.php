<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\Admin\CitiesModel;
use App\Libraries\AuthLib;

class Auth extends BaseController {

    public function login_view(){
        echo view('profile/login_view', [
            'title' => 'Войти',
            'success' => true
        ]);
    }

    public function login(){

        $userModel = new UserModel();
        $loginLib = new AuthLib();
        $data = [];
        $data_errors = [];

        if ($this->request->getMethod() == 'post'){
            $validation =  \Config\Services::validation();

            $rules = [
                'email' => 'required|min_length[6]|max_length[50]',
                'password' => 'required|min_length[4]|max_length[255]|validateUser[email,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => "Логин или пароль не верный",
                ],
            ];

            if (!$this->validate($rules, $errors)){
                $data_errors['validation'] = $validation->getErrors();
                echo "<pre>"; print_r($_POST); echo "</pre>";
                return $this->response->setJSON($data_errors);
            } else {

                $user = $userModel->where('email', $this->request->getVar('email'))
                    ->first();

                $loginLib->setUserSession($user);
                return redirect()->to(base_url().'/profile');
            }
        }
    }



    public function recovery_view(){
        echo view('profile/recovery_view', [
            'title' => 'Восстановить пароль',
            'success' => true
        ]);
    }


    public function recovery(){
        $data_error = [];
        $userModel = new UserModel();
        $authLib = new AuthLib();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $step = $this->request->getVar('step');

            if($step == 1){
                $rules = [
                    'phone' => 'required|min_length[9]|max_length[20]|is_not_unique[users.phone]',
                ];
                if (!$this->validate($rules)){
                    $data_errors['validation'] = $validation->getErrors();
                    return $this->response->setJSON($data_errors);
                } else {
                    $session = session();
                    $code_session = session()->get('code');

                    if($code_session == null){
                        $code = $authLib->getCode();
                        $code_session = $session->get('code');
                    }
                    $data_errors['code_session'] = $code_session;
                    $step_code = $this->request->getVar('step_code');

                    if($step_code){
                        $code_rules = [
                            'code' => 'required|min_length[4]|max_length[4]',
                        ];
                        if (!$this->validate($code_rules)){
                            $data_errors['code_rules'] = $validation->getErrors();
                            return $this->response->setJSON($data_errors);
                        } else {
                            $code_input = $this->request->getVar('code');
                            if($code_session == $code_input){
                                $data_errors['code_success'] = true;
                                return $this->response->setJSON($data_errors);
                            } else {
                                $data_errors['code_rules'] = [
                                    'code' => 'Код введен не верно'
                                ];
                                return $this->response->setJSON($data_errors);
                            }
                        }
                    } else {
                        return $this->response->setJSON($data_errors);
                    }

                }
            } else {

                $rules = [
                    'password' => 'required|min_length[8]|max_length[50]',
                    'password_confirm' => 'matches[password]',
                ];

                if (!$this->validate($rules)){
                    $data_errors['validation'] = $validation->getErrors();
                    return $this->response->setJSON($data_errors);
                } else {
                    $phone = $this->request->getVar('phone');
                    $password_id = $userModel->where('phone', $phone)->first();

                    $data = [
                        'password' => $this->request->getVar('password'),
                    ];
                    $userModel->update($password_id['id'], $data);
                    unset($_SESSION['code']);

                    $session = session();
                    $session->setFlashdata('success', 'Вы сменили пароль');

                    $data_errors['success'] = [
                        'redirect' => site_url('login')
                    ];
                    return $this->response->setJSON($data_errors);

                }
            }

        }

    }

    public function code_repeat_ajax()
    {
        $session = session();
        $authLib = new AuthLib();
        $session->remove('code');

        if($code_session == null){
            $code = $authLib->getCode();
            $code_session = $session->get('code');

            $data = [
                'success' => true,
                'code_session' => $code_session
            ];

            return $this->response->setJSON($data);
        }

        return false;

    }

    public function logout(){

        $loginLib = new AuthLib();
        $loginLib->setUserSession(false);

        return redirect()->to(base_url().'/login');
    }



}
