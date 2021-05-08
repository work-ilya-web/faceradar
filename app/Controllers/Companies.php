<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Models\CompaniesModel;
use App\Models\UserModel;
use App\Models\UserGroup;

class Companies extends BaseController
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
        if (!$loginLib->isLogin() OR !$loginLib->isAdmin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function index()
    {
        $loginLib = new AuthLib();
        $model = new CompaniesModel();
        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 10);

        $data = [
            'title' => 'Компании',
            'admin' => true,
            'menu_companies' =>true,
            'items' => $model->where('hide !=', 1)->paginate(10),
            'pager' => $model->pager,
            'count' => $model->countAll(),
        ];

        return view('profile/companies/list_view',  $data);

    }

    public function delete_ajax($id){
        $data = [];
        if(isset($id)){
            $model = new CompaniesModel();
            $model->delete($id);
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
        $model = new CompaniesModel();
        $UsersGroup = new UserGroup();


        switch ($event){
            case 'add':
                $data = [
                    'title' => 'Добавить компанию',
                    'menu_companies' =>true,
                    'action' => site_url('companies/add_ajax'),
                    'back_url' => site_url('companies'),
                    'url_add' => site_url('companies/add'),
                    'url_list' => site_url('companies'),
                ];
                break;
            case 'edit':
                if(is_numeric($id)){
                    $item = $model->find($id);
                    $agent = $this->request->getUserAgent();

                    if($item == null){
                        throw new \CodeIgniter\Exceptions\PageNotFoundException();
                    } else {
                        $data = [
                            'title' => 'Редактировать компанию',
                            'item' => $item,
                            'menu_companies' =>true,
                            'action' => site_url('companies/edit_ajax'),
                            'back_url' => $agent->getReferrer(),
                            'url_add' => site_url('companies/add'),
                            'url_list' => site_url('companies'),
                        ];
                    }
                } else {
                    throw new \CodeIgniter\Exceptions\PageNotFoundException();
                }

                break;

            default:
                throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }
        return view('profile/companies/item_view',  $data);

     }


    public function add_ajax(){

        $msg = [];
        $model = new CompaniesModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'camera_id' => 'required|min_length[1]|max_length[11]',
            ];

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {
                $newData = [
                    'name' => $this->request->getVar('name'),
                    'address' => $this->request->getVar('address'),
                    'camera_id' => $this->request->getVar('camera_id'),
                ];
                $model->save($newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

        return false;

    }

    public function edit_ajax(){
        $msg = [];
        $model = new CompaniesModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'name' => 'required|min_length[3]|max_length[50]',
                'camera_id' => 'required|min_length[1]|max_length[11]',
            ];

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {
                $id = $this->request->getVar('id');
                $newData = [
                    'name' => $this->request->getVar('name'),
                    'camera_id' => $this->request->getVar('camera_id'),
                    'address' => $this->request->getVar('address')
                ];
                $model->update($id, $newData);
                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }
        return false;
    }

}
