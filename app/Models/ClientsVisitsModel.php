<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientsVisitsModel extends Model
{
    protected $table = 'clients_visits';
    protected $allowedFields = ['clients_id','companies_id', 'create_at'];

    public function getVisites($params = []){

        $result = $visitsArray = [];

        if(!$params['companies_id']){
            $this->where('companies_id', $GLOBALS['user']['companies_id']);
        } else {
            $this->where('companies_id', $params['companies_id']);
        }
        if(!empty($params['from_date']) AND !empty($params['to_date'])){
            $this->where('create_at >=', $params['from_date']);
            $this->where('create_at <=', $params['to_date']);
        } else {
            if(!empty($params['from_date'])){
                $this->where('create_at', $params['from_date']);
            }
        }

        $visites =  $this->find();

        if(count($visites)>0){
            return $visites;
        } else {
            return false;
        }

    }

    public function getStatisticVisits($visites){
        $result = $visitsArray = [];
        //$visites  = $this->getVisites($params);
        if($visites){
            foreach ($visites as $key => $value) {
                $date = explode(' ', $value['create_at']);
                $visits[$key]['date'] = $date[0];
            }
            foreach ($visits as $key => $value) {
                $visitsArray[$value['date']][] = $value['id'];
            }
            foreach ($visitsArray as $key => $value) {
                $result[$key]['time'] = $key;
                $result[$key]['value'] = count($visitsArray[$key]);
            }
            ksort($result);
            return $result;
        } else {
            return false;
        }
    }


}
