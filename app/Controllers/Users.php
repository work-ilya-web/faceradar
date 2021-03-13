<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Models\UsersModel;
use App\Models\UserModel;
use App\Models\UserGroup;
use App\Models\CompaniesModel;

class Users extends BaseController
{

    function __construct()
    {
        $loginLib = new AuthLib();
        $userModel = new UserModel();
        $userGroupModel = new UserGroup();
        $session = session();
        $GLOBALS['user'] =  $userModel->GetUser($session->get('user')['id']);
        $GLOBALS['user']['permission'] =  $userGroupModel->GetUserPermission($GLOBALS['user']['group']);
        if (!$loginLib->isLogin() && !$loginLib->isAdmin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function index()
    {
        $loginLib = new AuthLib();
        $UsersModel = new UsersModel();
        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 10);

        if ($loginLib->isAdmin()) {

            $UsersList = $UsersModel->getUsers();
            $data = [
                'title' => 'Список клиентов',
                'admin' => true,
                'menu_users' =>true,
                'items' => $UsersList->paginate($in_page, 'users'),
                'pager' => $UsersModel->pager,
                'count' => $UsersModel->countAll(),
            ];
        } else {
            return 'Нет прав';
        }
        return view('profile/admin/users/list_view',  $data);

    }

    public function delete_ajax($id){
        $data = [];
        if(isset($id)){
            $UsersModel = new UsersModel();
            $UsersModel->delete($id);
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return $this->response->setJSON($data);

    }

    /**
     * View edit/add
     *
     * @param srting $event Event
     * @param int $id Id
     */

     public function item_view($event = 'add',  $id = false)
     {
        $loginLib = new AuthLib();
        $UsersModel = new UsersModel();
        $CompaniesModel = new CompaniesModel();
        $UsersGroup = new UserGroup();

        $rules = [
            'surname' => 'required|min_length[3]|max_length[50]',
            'name' => 'required|min_length[3]|max_length[50]',
            'patronymic' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|min_length[3]|max_length[50]|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[50]',
            'password_confirm' => 'required|matches[password]',
        ];

        if ($loginLib->isAdmin()) {
            switch ($event){
                case 'add':
                    $data = [
                        'title' => 'Добавление клиента',
                        'admin' => true,
                        'companies' => $CompaniesModel->findAll(),
                        'groups' => $UsersGroup->findAll(),
                        'action' => site_url('users/add_ajax'),
                        'url_add' => site_url('profile/users/add'),
                        'url_list' => site_url('profile/users'),
                        'rules'    => $rules
                    ];
                    break;
                case 'edit':
                    if(is_numeric($id)){
                        $userInfo = $UsersModel->GetUser($id);
                        $agent = $this->request->getUserAgent();

                        if($userInfo == null){
                            throw new \CodeIgniter\Exceptions\PageNotFoundException();
                        } else {
                            $data = [
                                'title' => 'Редактировать клиента',
                                'item' => $userInfo,
                                'admin' => true,
                                'action' => site_url('users/edit_ajax'),
                                'companies' => $CompaniesModel->findAll(),
                                'groups' => $UsersGroup->findAll(),
                                'url_add' => site_url('profile/users/add'),
                                'url_list' => site_url('profile/users'),
                                'rules'    => $rules
                            ];
                        }
                    } else {
                        throw new \CodeIgniter\Exceptions\PageNotFoundException();
                    }

                    break;

                default:
                    throw new \CodeIgniter\Exceptions\PageNotFoundException();

            }
            return view('profile/admin/users/item_view',  $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
     }


    public function add_ajax(){

        $msg = [];
        $UsersModel = new UsersModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'surname' => 'required|min_length[3]|max_length[50]',
                'name' => 'required|min_length[3]|max_length[50]',
                'patronymic' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|min_length[3]|max_length[50]|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[50]',
                'password_confirm' => 'required|matches[password]',
            ];

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {

                $newData = [
                    'surname' => $this->request->getVar('surname'),
                    'name' => $this->request->getVar('name'),
                    'patronymic' => $this->request->getVar('patronymic'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'companies_id' => $this->request->getVar('companies_id'),
                    'group' => $this->request->getVar('group')
                ];

                $save = $UsersModel->save($newData);
                //echo "<pre>"; print_r($newData); echo "</pre>";
                if($save){
                    $msg['success'] = true;
                } else {
                    $msg['success'] = false;
                }
                return $this->response->setJSON($msg);
            }

        }

        return false;

    }

    public function edit_ajax(){
        $msg = [];
        $UsersModel = new UsersModel();
        //echo "<pre>"; print_r($_POST); echo "</pre>";


        if ($this->request->getMethod() == 'post') {


            $validation =  \Config\Services::validation();

            $rules = [
                'surname' => 'required|min_length[3]|max_length[50]',
                'name' => 'required|min_length[3]|max_length[50]',
                'patronymic' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|min_length[3]|max_length[50]',
            ];

            $password = $this->request->getVar('password');
            $password_confirm = $this->request->getVar('password_confirm');

            if($password){
                $rules['password'] = 'required|min_length[8]|max_length[50]';
                $rules['password_confirm'] = 'required|matches[password]';
            }

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {
                $userID = $this->request->getVar('id');
                $newData = [
                    'surname' => $this->request->getVar('surname'),
                    'name' => $this->request->getVar('name'),
                    'patronymic' => $this->request->getVar('patronymic'),
                    'email' => $this->request->getVar('email'),
                    'companies_id' => $this->request->getVar('companies_id'),
                    'group' => $this->request->getVar('group')
                ];

                if($password){
                    $newData['password'] = $password;
                }
                $UsersModel->update($userID, $newData);
                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }
        return false;
    }

}
