<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Models\Admin\CitiesModel;

class City extends BaseController
{

    function __construct()
    {
        $loginLib = new AuthLib();
        if (!$loginLib->isLogin() && !$loginLib->isAdmin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }


    /**
     * Lister elements
     */

    public function index()
    {
        $loginLib = new AuthLib();
        $CitiesModel = new CitiesModel();

        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 10);

        if ($loginLib->isAdmin()) {
            if($_GET['search']){
                $CitiesList = $CitiesModel->FindCity($_GET['type'], $_GET['search'])->paginate($in_page, 'cities');
            } elseif($_GET['sort']){
                $CitiesList= $CitiesModel->sortCity($_GET['sort'], $_GET['sort_type'])->paginate($in_page, 'cities');
            } else {
                $CitiesList= $CitiesModel->paginate($in_page, 'cities');
            }

            $data = [
                'title' => 'Список городов',
                'admin' => true,
                'count' => count($CitiesList),
                'items' => $CitiesList,
                'pager' => $CitiesModel->pager,
            ];
        } else {
            return 'Нет прав';
        }
        return view('profile/admin/cities/list',  $data);
    }


    /**
     * Delete elements
     */

    public function delete_ajax(){
        $data = [];
        $id = $this->request->getVar('id');
        if(isset($id)){
            $CitiesModel = new CitiesModel();
            $CitiesModel->delete($id);
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
        $CitiesModel = new CitiesModel();        

        if ($loginLib->isAdmin()) {
            switch ($event){

                case 'add':
                    $data = [
                        'title' => 'Добавление города',
                        'admin' => true,
                        'action' => site_url('Admin/City/add_ajax'),
                        'back_url' => site_url('profile/cities'),
                    ];
                    break;

                case 'edit':
                    if(is_numeric($id)){
                        $cityInfo = $CitiesModel->GetCity($id);
                        $agent = $this->request->getUserAgent();

                        if ($cityInfo == null) {
                            throw new \CodeIgniter\Exceptions\PageNotFoundException();
                        } else {
                            $data = [
                                'title' => 'Редактировать',
                                'city' => $cityInfo,
                                'admin' => true,
                                'action' => site_url('Admin/City/edit_ajax'),
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

            return view('profile/admin/cities/item',  $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    /**
     * Add element for ajax
     */

    public function add_ajax(){
        
        $msg = [];
        $CitiesModel = new CitiesModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'city' => 'required|min_length[3]|max_length[250]|is_unique[cities.title]',
            ];

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {
                $newData = [
                    'title' => $this->request->getVar('city'),
                    'status' => (int)$this->request->getVar('status')
                ];

                $CitiesModel->save($newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

        return false;

    }


    /**
     * Edit element for ajax
     */

    public function edit_ajax(){
        $msg = [];
        $CitiesModel = new CitiesModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'city' => 'required|min_length[3]|max_length[250]',
            ];

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {
                $cityId = $this->request->getVar('city_id');

                $newData = [
                    'title' => $this->request->getVar('city'),
                    'status' => (int)$this->request->getVar('status')
                ];

                $CitiesModel->update($cityId, $newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

        return false;
    }
    
}