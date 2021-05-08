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

class Clients extends BaseController
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
        if (!$loginLib->isManager() AND !$loginLib->isAdmin()) {
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
        if($loginLib->isAdmin()){
            $CompaniesModel = new CompaniesModel();
            $Companies = $CompaniesModel->where('hide !=', 1)->find();
            if(isset($_GET['companies_id'])){
                $companies_id = $_GET['companies_id'];
            }
        }
        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 15);
        $items = $model->where('companies_id', $companies_id)->orderby('update_at','desc')->paginate(15);
        foreach ($items as $key => $item) {
            $items[$key]['photo'] = $ClientsPhotosModel->where('clients_id', $item['id'])->orderby('id','desc')->first();
            $items[$key]['visit'] = $ClientsVisitsModel->orderby('id','desc')->where('clients_id', $item['id'])->first();
        }
        //echo "<pre>"; print_r($items); echo "</pre>";

        $data = [
            'title' => 'Клиенты',
            'admin' => true,
            'menu_companies' =>true,
            'url_add' => site_url('clients/add'),
            'url_photos' => site_url('clients_photos'),
            'items' => $items,
            'pager' => $model->pager,
            'companies' => @$Companies,
            'admin' => (($loginLib->isAdmin())?true:false),
            'count' => $model->countAll(),
        ];

        return view('profile/clients/list_view',  $data);

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
                $msg['html'] = view('profile/clients/row_view',  $data);
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



    public function delete_ajax($id){
        $data = [];
        if(isset($id)){
            $model = new ClientsModel();
            $model->delete($id);
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return $this->response->setJSON($data);
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

    /**
     * View edit/add
     *
     * @param srting $event Event
     * @param int $id Id
     */

     public function item_view($event = 'add',  $id = false)
     {
        $loginLib = new AuthLib();
        $model = new ClientsModel();
        $UsersGroup = new UserGroup();

        $fields = [
             'name' => [
                'type'  => 'text',
                'title' => 'Имя'
             ],
             'surname' => [
                'type' => 'text',
                'title' => 'Фамилия'
             ],
             'patronymic' => [
                'type' => 'text',
                'title' => 'Отчество'
             ],
             'email' => [
                'type' => 'email',
                'title' => 'Email'
             ],
             'date_birth' => [
                'type' => 'text',
                'title' => 'Дата рождения'
             ],
             'phone' => [
                'type' => 'text',
                'title' => 'Телефон'
             ],
             'comment' => [
                'type' => 'text',
                'title' => 'Комментарий'
             ],
             'sex' => [
                'type' => 'select',
                'title' => 'Пол',
                'options' => [
                    1 => 'Мужской',
                    2 => 'Женский',
                ]
             ]
        ];


        switch ($event){
            case 'add':
                $data = [
                    'title' => 'Добавить клиента',
                    'menu_companies' =>true,
                    'action' => site_url('clients/add_ajax'),
                    'url_add' => site_url('clients/add'),
                    'url_list' => site_url('clients'),
                    'fields'   => $fields
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
                            'title' => 'Редактировать клиента',
                            'item' => $item,
                            'menu_companies' =>true,
                            'action' => site_url('clients/edit_ajax'),
                            'back_url' => $agent->getReferrer(),
                            'url_add' => site_url('clients/add'),
                            'url_list' => site_url('clients'),
                            'fields'   => $fields
                        ];
                    }
                } else {
                    throw new \CodeIgniter\Exceptions\PageNotFoundException();
                }

                break;

            default:
                throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }
        return view('profile/clients/item_view',  $data);

     }


     public function update(){

         $msg = [];
         $msg['success'] = false;
         $ClientsModel = new ClientsModel();

         if ($this->request->getMethod() == 'post') {
             if(isset($_POST['id']) AND is_numeric($_POST['id'])){
                 $client = $ClientsModel->find($_POST['id']);

                 if(!empty($client)){
                     $newData = [
                         'name' => $_POST['name'],
                         'surname' => $_POST['surname'],
                         'patronymic' => $_POST['patronymic'],
                         'email' => $_POST['email'],
                         'date_birth' => $_POST['date_birth'],
                         'year_birth' => $_POST['year_birth'],
                         'sex' => $_POST['sex'],
                         'phone' => $_POST['phone'],
                         'comment' => $_POST['comment'],
                     ];
                     $ClientsModel->update($_POST['id'], $newData);
                     $msg['success'] = true;
                     $msg['mess'] = 'Информация сохранена';
                 } else {
                     $msg['mess'] = 'Not found CLIENT';
                 }
            } else {
                $msg['mess'] = 'Not found ID';
            }
         } else {
             $msg['mess'] = 'No data received';
         }

         return $this->response->setJSON($msg);

     }


    public function add_ajax(){

        $msg = [];
        $model = new ClientsModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();


            $newData = [
                'name'          => $this->request->getVar('name'),
                'surname'       => $this->request->getVar('surname'),
                'patronymic'    => $this->request->getVar('patronymic'),
                'email'         => $this->request->getVar('email'),
                'date_birth'    => $this->request->getVar('date_birth'),
                'phone'         => $this->request->getVar('phone'),
                'comment'       => $this->request->getVar('comment'),
                'sex'           => $this->request->getVar('sex'),
                'companies_id'  => $GLOBALS['user']['companies']['id']
            ];

            if ($model->insert($newData)) {
                $msg['success'] = true;
            } else {
                $msg['success'] = false;
            }

            return $this->response->setJSON($msg);


        }

        return false;

    }

    public function edit_ajax(){
        $msg = [];
        $model = new ClientsModel();

        if ($this->request->getMethod() == 'post') {
            $validation =  \Config\Services::validation();
            $id = $this->request->getVar('id');
            $newData = [
                'name' => $this->request->getVar('name'),
                'address' => $this->request->getVar('address')
            ];
            $model->update($id, $newData);
            $msg['success'] = true;
            return $this->response->setJSON($msg);


        }
        return false;
    }


    public function updateVisited()
    {
        $loginLib = new AuthLib();
        $ClientsModel = new ClientsModel();
        $ClientsVisitsModel = new ClientsVisitsModel();
        $items = $ClientsModel->orderby('update_at','desc')->find();
        foreach ($items as $key => $item) {
            $items[$key]['visit'] = $ClientsVisitsModel->orderby('id','desc')->where('clients_id', $item['id'])->find();
            $ClientsModel->update($item['id'], ['total_visits'=>count($items[$key]['visit'])]);
        }
    }
}
