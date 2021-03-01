<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Models\Admin\UsersModel;
use App\Models\Admin\CitiesModel;
use App\Models\UserGroup;

class Users extends BaseController
{

    function __construct()
    {
        $loginLib = new AuthLib();
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
            if($_GET['search']){
                $UsersList = $UsersModel->FindUser($_GET['type'], $_GET['search']);
            } elseif($_GET['sort']){
                $UsersList = $UsersModel->sortUser($_GET['sort'], $_GET['sort_type']);
            } else {
                $UsersList = $UsersModel->getUsers();
            }

            $data = [
                'title' => 'Список клиентов',
                'admin' => true,
                'items' => $UsersList->paginate($in_page, 'users'),
                'pager' => $UsersModel->pager,
                'count' => $UsersModel->countAll(),
            ];
        } else {
            return 'Нет прав';
        }
        return view('profile/admin/users/list',  $data);

    }

    public function delete_ajax(){
        $data = [];
        $id = $this->request->getVar('id');
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
        $CitiesModel = new CitiesModel();
        $UsersGroup = new UserGroup();  

        if ($loginLib->isAdmin()) {
            switch ($event){
                case 'add':
                    $data = [
                        'title' => 'Добавление клиента',
                        'admin' => true,
                        'cities' => $CitiesModel->RegisterCities(),
                        'groups' => $UsersGroup->findAll(),
                        'action' => site_url('Admin/Users/add_ajax'),
                        'back_url' => site_url('profile/users'),
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
                                'user' => $userInfo,
                                'admin' => true,
                                'action' => site_url('Admin/Users/edit_ajax'),
                                'cities' => $CitiesModel->RegisterCities(),
                                'cities_current' => $CitiesModel->GetCity($userInfo['city_id']),
                                'groups_current' => $UsersGroup->GetUserPermission($userInfo['group']),
                                'back_url' => $agent->getReferrer(),
                            ];
                        }
                    } else {
                        throw new \CodeIgniter\Exceptions\PageNotFoundException();
                    }

                    break;

                default:
                    throw new \CodeIgniter\Exceptions\PageNotFoundException();

            }
            return view('profile/admin/users/item',  $data);
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
                'phone' => 'required|min_length[3]|max_length[20]|is_unique[users.phone]',
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
                    'phone' => $this->request->getVar('phone'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'city_id' => $this->request->getVar('city_id'),
                    'group' => '2',
                ];

                $UsersModel->save($newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

        return false;

    }

    public function edit_ajax(){
        $msg = [];
        $UsersModel = new UsersModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'surname' => 'required|min_length[3]|max_length[50]',
                'name' => 'required|min_length[3]|max_length[50]',
                'patronymic' => 'required|min_length[3]|max_length[50]',
                'phone' => 'required|min_length[3]|max_length[20]',
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
                $userID = $this->request->getVar('user_id');
                $newData = [
                    'surname' => $this->request->getVar('surname'),
                    'name' => $this->request->getVar('name'),
                    'patronymic' => $this->request->getVar('patronymic'),
                    'phone' => $this->request->getVar('phone'),
                    'email' => $this->request->getVar('email'),
                    'city_id' => $this->request->getVar('city_id'),
                    'group' => '2',
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