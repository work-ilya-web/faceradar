<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class CitiesModel extends Model
{
    protected $table = 'cities';
    protected $allowedFields = ['title', 'status'];

    public function RegisterCities(){
        return $this->where('status =', 1)->find();
    }

    public function GetCities($paginate){
        return $this->paginate($paginate);
    }

    public function FindCity($type, $input){
        if($type && $input){
            $result = $this->like($type, $input);
            return $result;
        }
        return false;
    }

    public function sortCity($type, $input)
    {
        if($type && $input){
        
            $result = $this->orderBy($type, $input);
            return $result;
        }
        return false;
    }
   
    public function GetCity($id){
        return $this->where('id', $id)->first();
    }

}
