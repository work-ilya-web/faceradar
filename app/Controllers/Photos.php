<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Libraries\PhotosLib;
use App\Models\PhotosModel;
use App\Models\ClientsModel;
use App\Models\ClientsPhotosModel;
use App\Models\ClientsVisitsModel;
use App\Models\CompaniesModel;


class Photos extends BaseController
{

    public function index(){
        $fields = [
             'url' => [
                'type'   => 'file',
                'title'  => 'Фото',
                'accept' => 'accept="image/jpeg,image/png,image/gif"'
             ]
        ];
        $data = [
            'title' => 'Добавить фото',
            'menu_companies' =>true,
            'action' => 'http://faceradar.copyl.ru/photos/add/fdM4PQX91aTaoSrgBukY5O6',
            'fields'   => $fields,
        ];
        return view('profile/photos/item_view',  $data);
    }

    public function add($key = false){
        $msg = [];
        if($key == 'fdM4PQX91aTaoSrgBukY5O6'){
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

                            $PhotosModel = new PhotosModel();
                            $newData = [
                                'url'          => $url_file,
                                'camera_id'   => @$_POST['idSource']
                            ];
                            $PhotosModel->save($newData);

                        } else {
                            $msg['validation']['file'] = $file->getErrorString().'('.$file->getError().')';
                        }
                    } else {
                        $msg['validation']['file'] = 'Файл не найден';
                    }

                }
            } else {
                $msg['validation']['file'] = 'Файл не найден';
            }
        } else {
            $msg['validation']['key'] = 'Не верный key';
        }


        return $this->response->setJSON($msg);


    }

    public function send(){

        $ClientsModel = new ClientsModel();
        $ClientsVisitsModel = new ClientsVisitsModel();
        $ClientsPhotosModel = new ClientsPhotosModel();
        $CompaniesModel = new CompaniesModel();
        $PhotosModel = new PhotosModel();
        $PhotosLib = new PhotosLib();
        $msg = $feceResult = [];
        $faces = $PhotosModel->orderBy('id','desc')->paginate(5);

        if(count($faces) > 0){
            foreach ($faces as $key => $face) {
                $feceResult[$key] = $PhotosLib->identifyFace( $face['url'],$face['camera_id']);

                $feceResult[$key]->photo        = $face['url'];
                $feceResult[$key]->camera_id    = $face['camera_id'];
                $feceResult[$key]->photo_id     = $face['id'];
            }

            foreach ($feceResult as $face) {
                    $client = $ClientsModel->where('face_id',$face->id )->find();

                    if(count($client)==0){
                        # добавляем клиента в базу
                        $company = $CompaniesModel->where('camera_id', $face->camera_id )->first();
                        $clientArray = [
                            'face_id'       => $face->id,
                            'year_birth'    => $PhotosLib->getYearBirth($face->age),
                            'sex'           => $PhotosLib->getGender($face->gender),
                            'companies_id'  => $company['id'],
                            'total_visits'  => 1,
                            'quick_show'    => 1,
                        ];
                        $clients_id = $ClientsModel->insert($clientArray);
                        $msg[]['client'] = 'Added new: '.$clients_id;

                        # добавляем визит в базу
                        $visitArray['clients_id'] = $clients_id;
                        $visit_id = $ClientsVisitsModel->insert($visitArray);
                        $msg[]['visit'] = 'Added new: '.$visit_id;

                        # добавляем фото в базу
                        $photosArray = [
                            'url'        => $face->photo,
                            'clients_id' => $clients_id,
                            'visits_id'  => $visit_id
                        ];
                        $photo_id = $ClientsPhotosModel->insert($photosArray);
                        $msg[]['photo'] = 'Added new: '.$photo_id.' - '.$face->photo;

                        # удаляем из очереди на обработку
                        $PhotosModel->delete($face->photo_id);

                    } else {
                        # обновляем клиента в базе
                        $updateClient = $ClientsModel->update($client[0]['id'], ['total_visits'=>$client[0]['total_visits']+1, 'quick_show'=> 1  ]);
                        $msg[]['client'] = 'Updated: face_id - '.$client[0]['face_id'];

                        # добавляем визит в базу
                        $visitArray['clients_id'] = $client[0]['id'];
                        $visit_id = $ClientsVisitsModel->insert($visitArray);
                        $msg[]['visit'] = 'Added new: for face_id - '.$client[0]['face_id'];

                        # добавляем фото в базу
                        $photosArray = [
                            'url'        => $face->photo,
                            'clients_id' => $client[0]['id'],
                            'visits_id'  => $visit_id
                        ];
                        $photo_id = $ClientsPhotosModel->insert($photosArray);
                        $msg[]['photo'] = 'Added new: '.$photo_id.' - '.$face->photo;

                        # удаляем из очереди на обработку
                        $PhotosModel->delete($face->photo_id);

                        # удаляем фото с сервера так как клиент уже в базе
                        //unlink(WRITEPATH.$face->url);
                    }
                }
        } else {
                $msg['mess'] = 'Not found faces';
        }


        return $this->response->setJSON($msg);

    }


}
