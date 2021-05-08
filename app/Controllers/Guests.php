<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Models\ClientsModel;
use App\Models\ClientsPhotosModel;
use App\Models\ClientsVisitsModel;
use App\Models\CompaniesModel;
use App\Models\UserModel;
use App\Models\UserGroup;

class Guests extends BaseController
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
        if (!$loginLib->isReception() ) {
            echo 'Access is denied';
            exit();
        }
    }

    public function index()
    {
        $loginLib = new AuthLib();
        $model = new ClientsModel();
        $ClientsPhotosModel = new ClientsPhotosModel();
        $ClientsVisitsModel = new ClientsVisitsModel();
        $companies_id = $GLOBALS['user']['companies_id'];

        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 15);
        $items = $model->where('companies_id', $companies_id)->orderby('update_at','desc')->paginate(15);
        foreach ($items as $key => $item) {
            $items[$key]['photo'] = $ClientsPhotosModel->where('clients_id', $item['id'])->orderby('id','desc')->first();
            $items[$key]['visit'] = $ClientsVisitsModel->orderby('id','desc')->where('clients_id', $item['id'])->first();
        }
        //echo "<pre>"; print_r($items); echo "</pre>";

        $data = [
            'title' => 'Гости',
            'admin' => true,
            'menu_companies' =>true,
            'url_photos' => site_url('clients_photos'),
            'items' => $items,
            'pager' => $model->pager,
            'companies' => @$Companies,
            'admin' => (($loginLib->isAdmin())?true:false),
            'count' => $model->countAll(),
        ];

        return view('profile/guests/list_view',  $data);

    }




    public function get_row($id = null)
    {
        $msg = [];
        $msg['success'] = false;
        if(is_numeric($id)){
            $ClientsModel = new ClientsModel();
            $ClientsPhotosModel = new ClientsPhotosModel();
            $ClientsVisitsModel = new ClientsVisitsModel();
            $item = $ClientsModel->find($id);
            if($item){
                $item['photo'] = $ClientsPhotosModel->where('clients_id', $item['id'])->orderby('id','desc')->first();
                $item['visit'] = $ClientsVisitsModel->orderby('id','desc')->where('clients_id', $item['id'])->first();

                $data = [
                    'item' => $item,
                    'style' => @$_POST['style'],
                    'url_photos' => site_url('clients_photos'),
                ];
                $msg['html'] = view('profile/guests/row_view',  $data);
                $msg['id'] = $item['id'];

                if(isset($_POST['quick_show']) AND $_POST['quick_show'] == 0){
                     $ClientsModel->update($id, ['quick_show'=>0]);
                     $msg['mess'] = 'hide from quick_show';
                }


                $msg['success'] = true;
            } else {
                $msg['mess'] = 'client not found';
            }
        } else {
            $msg['mess'] = 'id not found';
        }
        return $this->response->setJSON($msg);
    }



    public function get_quick_clients(){
        $data = [];
        $ClientsModel = new ClientsModel();
        $ClientsPhotosModel = new ClientsPhotosModel();
        $data['clients'] = $ClientsModel->where('quick_show', 1)->where('companies_id', $GLOBALS['user']['companies_id'])->orderby('id','desc')->find();

        if(empty($data['clients'])){
            $data['success'] = false;
        } else {
            $data['success'] = true;
        }

        return $this->response->setJSON($data);
    }

    public function get_client(){
        $data = [];
        if(isset($_POST['id']) AND is_numeric(@$_POST['id'])){
            $model = new ClientsModel();
            $ClientsPhotosModel = new ClientsPhotosModel();
            $data['client'] = $model->find($_POST['id']);

            if(empty($data['client'])){
                $data['mess'] = 'Не найден такой клиент';
                $data['success'] = false;
            } else {


                $data['client']['photo'] = $ClientsPhotosModel->where('clients_id', $_POST['id'])->orderby('id','desc')->first();

                if(empty($data['client']['photo'])){
                    $data['client']['photo']['url'] = '/assets/img/no-photo.jpg';
                } else{
                    $data['client']['photo']['url'] = '/writable/'.$data['client']['photo']['url'];
                }

                $data['success'] = true;
            }

        } else {
            $data['success'] = false;
            $data['mess'] = 'Не верный ID';
        }
        return $this->response->setJSON($data);
    }


}
