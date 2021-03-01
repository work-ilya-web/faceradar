<?php

namespace App\Controllers\Client;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Models\AddressModel;
use App\Models\Admin\CitiesModel;

class Address extends BaseController {


    function __construct()
    {
        $loginLib = new AuthLib();
        if (!$loginLib->isLogin()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function index()
    {
        $addressModel = new AddressModel();
        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 10);

        
        if($_GET['sort']){
            $addressList = $addressModel->listSort($_GET['sort'], $_GET['sort_type'])->paginate($in_page, 'address');
        } elseif($_GET['search']){
            $addressList = $addressModel->listSearch($_GET['type'], $_GET['search'])->paginate($in_page, 'address');
            
        } else {
            $addressList = $addressModel->getList(session()->get('user')['id'])->paginate($in_page, 'address');
        }

        $data = [
            'title' => 'Список адресов',
            'count' => $addressModel->countAll(),
            'items' => $addressList,
            'pager' => $addressModel->pager,
        ];

        return view('profile/address/list',  $data);
    }

    /**
     * View edit/add
     *
     * @param srting $event Event
     * @param int $id Id
     */

    public function item_view($event = 'add',  $id = false)
    {
        $addressModel = new AddressModel();
        $cityList = new CitiesModel();

        switch ($event){
            case 'add':
                if($id == false){
                    $data = [
                        'title' => 'Добавление адреса',
                        'cities' => $cityList->RegisterCities(),
                        'action' => site_url('Client/Address/add_ajax'),
                        'back_url' => site_url('profile/address'),
                    ];
                } else {
                    throw new \CodeIgniter\Exceptions\PageNotFoundException();
                }
                break;
            
            case 'edit':
                if(is_numeric($id)){
                    $addressInfo = $addressModel->getItem($id);
                    $agent = $this->request->getUserAgent();
                    if($addressInfo == null || $addressInfo == ''){
                        throw new \CodeIgniter\Exceptions\PageNotFoundException();
                    } else {
                        $data = [
                            'title' => 'Редактировать',
                            'address' => $addressInfo,
                            'cities' => $cityList->RegisterCities(),
                            'cities_current' => $cityList->GetCity($addressInfo['city_id']),
                            'action' => site_url('Client/Address/edit_ajax'),
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

        return view('profile/address/item',  $data);
    }
    

    public function delete_ajax(){
        $data = [];
        $id = $this->request->getVar('id');
        if(isset($id)){
            $addressModel = new AddressModel();
            $addressModel->delete($id);
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return $this->response->setJSON($data);

    }


    public function add_ajax(){
        
        $msg = [];
        $addressModel = new AddressModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'title' => 'required|min_length[3]|max_length[250]',
                'street' => 'required|min_length[3]|max_length[250]',
                'house' => 'required|max_length[50]',
                'flat' => 'required|max_length[50]',
                'floo' => 'required|max_length[50]',
                'comment' => 'max_length[255]',
            ];

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {
                $newData = [
                    'title' => $this->request->getVar('title'),
                    'city_id' => (int)$this->request->getVar('city_id'),
                    'street' => $this->request->getVar('street'),
                    'house' => $this->request->getVar('house'),
                    'flat' => $this->request->getVar('flat'),
                    'floo' => $this->request->getVar('floo'),
                    'comment' => $this->request->getVar('comment'),
                    'user_id' => session()->get('user')['id'],
                ];

                $addressModel->save($newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

        return false;

    }


    public function edit_ajax(){
        
        $msg = [];
        $addressModel = new AddressModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();

            $rules = [
                'title' => 'required|min_length[3]|max_length[250]',
                'street' => 'required|min_length[3]|max_length[250]',
                'house' => 'required|max_length[50]',
                'flat' => 'required|max_length[50]',
                'floo' => 'required|max_length[50]',
                'comment' => 'max_length[255]',
            ];

            if (!$this->validate($rules)){
                $msg['validation'] = $validation->getErrors();
                return $this->response->setJSON($msg);
            } else {
                $currentID = $this->request->getVar('current_id');

                $newData = [
                    'title' => $this->request->getVar('title'),
                    'city_id' => (int)$this->request->getVar('city_id'),
                    'street' => $this->request->getVar('street'),
                    'house' => $this->request->getVar('house'),
                    'flat' => $this->request->getVar('flat'),
                    'floo' => $this->request->getVar('floo'),
                    'comment' => $this->request->getVar('comment'),
                ];

                $addressModel->save($newData);

                $msg['success'] = true;
                return $this->response->setJSON($msg);
            }

        }

        return false;

    }

}