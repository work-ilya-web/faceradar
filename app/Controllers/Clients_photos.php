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

class Clients_photos extends BaseController
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
        if (!$loginLib->isManager() AND !$loginLib->isAdmin() AND !$loginLib->isReception()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function index($clients_id = false)
    {
        $loginLib = new AuthLib();
        $model = new ClientsPhotosModel();
        $ClientsModel = new ClientsModel();
        $ClientsVisitsModel = new ClientsVisitsModel();
        $in_page = ($this->request->getVar('in_page') ? $this->request->getVar('in_page') : 10);
        $items = $model->where('clients_id', $clients_id )->orderby('id', 'desc')->paginate(10);

        foreach ($items as $key=>$value) {
            $items[$key]['visite'] = $ClientsVisitsModel->find($value['visits_id']);
        }
        $data = [
            'title' => 'Фото клиента',
            'admin' => true,
            'menu_clients' =>true,
            'url_add' => site_url('clients_photos/add'),
            'items' => $items,
            'pager' => $model->pager,
            'count' => $model->countAll(),
            'clients_id' => $clients_id,
            'client'     => $ClientsModel->first($clients_id)
        ];
        if ($loginLib->isReception()) {
            $data['isReception'] = true;
        }

        //echo "<pre>"; print_r($data); echo "</pre>";
        return view('profile/clients_photos/list_view',  $data);

    }

    public function delete_ajax($id){
        $loginLib = new AuthLib();
        $data = [];
        if(isset($id) and !$loginLib->isReception()){
            $model = new ClientsPhotosModel();
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

     public function item_view($client_id = false, $event = 'add',  $id = false)
     {
        $loginLib = new AuthLib();
        $model = new CompaniesModel();
        $UsersGroup = new UserGroup();
        $ClientsModel = new ClientsModel();
        if ($loginLib->isReception()) {exit(); }

        $fields = [
             'url' => [
                'type'   => 'file',
                'title'  => 'Фото',
                'accept' => 'accept="image/jpeg,image/png,image/gif"'
             ]
        ];

        switch ($event){
            case 'add':
                $data = [
                    'title' => 'Добавить фото',
                    'menu_companies' =>true,
                    'action' => site_url('clients_photos/add_ajax'),
                    'url_add' => site_url('clients_photos/'.$client_id.'/add'),
                    'url_list' => site_url('clients_photos/'.$client_id),
                    'fields'   => $fields,
                    'client'   => $ClientsModel->find($client_id)
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
                            'action' => site_url('clients_photos/edit_ajax'),
                            'back_url' => $agent->getReferrer(),
                            'url_add' => site_url('clients_photos/'.$client_id.'/add'),
                            'url_list' => site_url('clients_photos/'.$client_id),
                            'fields'   => $fields,
                            'client'     => $ClientsModel->find($clients_id)
                        ];
                    }
                } else {
                    throw new \CodeIgniter\Exceptions\PageNotFoundException();
                }

                break;

            default:
                throw new \CodeIgniter\Exceptions\PageNotFoundException();

        }
        return view('profile/clients_photos/item_view',  $data);

     }


    public function add_ajax(){
        $loginLib = new AuthLib();
        $msg = [];
        $model = new ClientsPhotosModel();
        $path_download = WRITEPATH.'uploads/clients_photos';

        if ($loginLib->isReception()) {exit(); }

        if($imagefile = $this->request->getFiles())
        {
            if($img = $imagefile['file'])
            {
                if ($img->isValid() && ! $img->hasMoved())
                {
                    $newName = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                    $img->move($path_download, $newName);
                    $url_file = 'uploads/clients_photos/'.$img->getName();
                } else {
                    $msg['validation']['file'] = $file->getErrorString().'('.$file->getError().')';
                }
            } else {
                $msg['validation']['file'] = 'Файл не выбран';
            }
        } else {
            $msg['validation']['file'] = 'Файл не выбран';
        }


        if(!isset($msg['validation']['file'])){
            $newData = [
                'url'          => $url_file,
                'clients_id'   => $this->request->getVar('clients_id')
            ];
            $model->save($newData);

            $msg['success'] = true;
            return $this->response->setJSON($msg);

        } else {
            return $this->response->setJSON($msg);
        }

        return false;

    }


}
