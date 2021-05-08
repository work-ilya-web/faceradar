<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\AuthLib;
use App\Libraries\PhotosLib;
use App\Models\ClientsModel;
use App\Models\ClientsPhotosModel;
use App\Models\ClientsVisitsModel;
use App\Models\CompaniesModel;
use App\Models\UserModel;
use App\Models\UserGroup;

class Search extends BaseController
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
        $PhotosLib = new PhotosLib();
        $ClientsModel = new ClientsModel();
        $ClientsPhotosModel = new ClientsPhotosModel();
        $ClientsVisitsModel = new ClientsVisitsModel();
        $companies_id = $GLOBALS['user']['companies_id'];
        $path_download = WRITEPATH.'uploads/photos';
        if($imagefile = $this->request->getFiles())
        {

            foreach ($imagefile as $key => $value) {
                if($img = $imagefile[$key])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $newName = $img->getRandomName();
                        $img->move($path_download, $newName);
                        $url_file = 'uploads/photos/'.$img->getName();
                        $msg['url'] = 'Saved: '.$url_file;
                        $msg['id'] = $_POST['idSource'];


                        $img = [
                            'url'          => $url_file,
                            'camera_id'   => @$_POST['idSource']
                        ];
                        $result = $PhotosLib->identifyFace( $img['url'],$img['camera_id']);
                        $client = $ClientsModel->where('face_id',$result->id )->find();
                        foreach ($client as $key => $item) {
                            $client[$key]['photo'] = $ClientsPhotosModel->where('clients_id', $item['id'])->orderby('id','desc')->first();
                            $client[$key]['visit'] = $ClientsVisitsModel->orderby('id','desc')->where('clients_id', $item['id'])->first();
                        }
                    } else {
                        $msg['validation']['file'] = 'error';
                    }
                } else {
                    $msg['validation']['file'] = 'Файл не найден';
                }

            }
        }





        $data = [
            'title' => 'Клиенты',
            'admin' => true,
            'menu_companies' =>true,
            'url_photos' => site_url('clients_photos'),
            'item' => $client[0],
            'img' => $img,
            'result' => $result,
            'companies' => @$Companies,
            'admin' => (($loginLib->isAdmin())?true:false),
        ];

        return view('profile/search/list_view',  $data);

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
