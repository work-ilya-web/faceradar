<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Models\UsersModel;
use App\Models\UserModel;
use App\Models\UserGroup;
use App\Models\CompaniesModel;

class Receptions extends BaseController
{

    function __construct()
    {
        $loginLib = new AuthLib();
        $userModel = new UserModel();
        $userGroupModel = new UserGroup();
        $CompaniesModel = new CompaniesModel();
        $session = session();
        $GLOBALS['user'] =  $userModel->GetUser($session->get('user')['id']);
        $GLOBALS['user']['permission'] =  $userGroupModel->GetUserPermission($GLOBALS['user']['group']);
        $GLOBALS['user']['companies'] =  $CompaniesModel->find($GLOBALS['user']['companies_id']);
        if (!$loginLib->isAdmin() AND !$loginLib->isManager()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function index()
    {
        $loginLib = new AuthLib();
        $UsersModel = new UsersModel();
        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 10);

        $UsersList = $UsersModel->getReceptions();
        $data = [
            'title' => 'Список пользователей Receptions',
            'menu_receptions' =>true,
            'items' => $UsersList->paginate($in_page, 'users'),
            'pager' => $UsersModel->pager,
            'url_add'   => site_url('receptions/add'),
        ];

        return view('profile/receptions/list_view',  $data);

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
        helper('text');
        $loginLib = new AuthLib();
        $UsersModel = new UsersModel();
        $CompaniesModel = new CompaniesModel();
        $UsersGroup = new UserGroup();
        //echo "<pre>"; print_r($GLOBALS['user']); echo "</pre>";
        $rules = [
            'surname' => 'required|min_length[3]|max_length[50]',
            'name' => 'required|min_length[3]|max_length[50]',
            'patronymic' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|min_length[3]|max_length[50]|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[50]',
            'password_confirm' => 'required|matches[password]',
        ];


        switch ($event){
            case 'add':
                $data = [
                    'title'     => 'Добавление пользователя',
                    'action'    => site_url('receptions/add_ajax'),
                    'url_add'   => site_url('receptions/add'),
                    'url_list'  => site_url('receptions'),
                    'rules'     => $rules
                ];
                break;
            case 'edit':
                if(is_numeric($id)){
                    $userInfo = $UsersModel->GetUser($id);

                    if($userInfo == null OR $userInfo['group'] != 3){
                        throw new \CodeIgniter\Exceptions\PageNotFoundException();
                    } else {
                        $data = [
                            'title' => 'Редактировать пользователя',
                            'item' => $userInfo,
                            'action' => site_url('receptions/edit_ajax'),
                            'url_add' => site_url('receptions/add'),
                            'url_list' => site_url('receptions'),
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
        return view('profile/receptions/item_view',  $data);

     }


    public function add_ajax(){
        helper('text');
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
                    'surname'       => $this->request->getVar('surname'),
                    'name'          => $this->request->getVar('name'),
                    'patronymic'    => $this->request->getVar('patronymic'),
                    'email'         => $this->request->getVar('email'),
                    'password'      => $this->request->getVar('password'),
                    'companies_id'  => $GLOBALS['user']['companies']['id'],
                    'group'         => 3
                ];

                $save = $UsersModel->save($newData);
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
                    'email' => $this->request->getVar('email')
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
