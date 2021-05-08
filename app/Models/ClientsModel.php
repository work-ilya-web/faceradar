<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientsModel extends Model
{
    protected $table = 'clients';
    protected $allowedFields = ['face_id','name', 'surname', 'patronymic', 'email',  'companies_id', 'date_birth', 'year_birth', 'sex', 'phone', 'comment', 'total_visits', 'quick_show'];


    public function getStatisticGenders($visites){
        $clients = $genders = $gender = [];
        $percent = 0;

        if($visites){
            $percent = count($visites) / 100;
            foreach ($visites as $key => $value) {
                $clients[] = $this->find($value['clients_id']);
            }
            foreach ($clients as $key => $value) {
                $genders[$value['sex']][] = $value['id'];
            }
            for ($i=0; $i < 3; $i++) {
                if(isset($genders[$i])){
                    $gender[$i]['total'] = count($genders[$i]);
                }
            }
            for ($i=0; $i < 3; $i++) {
                if(isset($gender[$i]['total'])){
                    $gender[$i]['percent'] = round($gender[$i]['total'] / $percent, 2);
                }
            }
            return $gender;
        } else {
            return false;
        }
    }

    public function getStatisticAttendance($visites){
        $clients = $attendance =  [];
        $attendance['old'] = $attendance['new'] = 0;
        $percent = 0;

        if($visites){

            foreach ($visites as $key => $value) {
                $clients[$value['clients_id']][] = $value['id'];
            }
            foreach ($clients as $key => $value) {
                if(count($value) > 1){
                    $attendance['old']++;
                }
                if(count($value) == 1){
                    $attendance['new']++;
                }
            }
            $percent =($attendance['old'] + $attendance['new']) / 100;
            $attendance['old'] = round($attendance['old'] / $percent, 2);
            $attendance['new'] = round($attendance['new'] / $percent, 2);
            return $attendance;
        } else {
            return false;
        }
    }
}
