<?php


namespace App\Models;
use CodeIgniter\Model;

class AddressModel extends Model {
    protected $table = 'address';
    protected $allowedFields = ['title', 'city_id', 'street', 'house', 'flat', 'floo', 'comment', 'user_id', 'create_at'];


    public function getList($user_id = false)
    {

        if(!$user_id){
            $user_id = session()->get('user')['id'];
        }

        $this->select('address.id as address_id, address.title as address_title, cities.title as city_title, street, house, flat, comment, create_at');
        
        if($user_id){
            $this->where('user_id', $user_id);
        }

        $this->join('cities', 'address.city_id=cities.id');
        return $this;
    }

    public function getItem($id)
    {
        return $this->where('id', $id)->first();
    }

    public function listSort($type, $input)
    {
        if($type && $input){
            $this->getList();
            $this->orderBy('address.' . $type . '', $input);

            return $this;
        }
        return false;
    }
    
    public function listSearch($type, $input)
    {
        if($type && $input){
            $this->getList();
            if($type == 'city_title'){
                $this->like('cities.title', $input);
            } else {
                $this->like('address.' . $type . '', $input);
            }
            return $this;
        }
        return false;
    }

    public function listLast($user_id, $paginate)
    {   
        if($user_id){
            $this->select('address.id as address_id, address.title as address_title, cities.title as city_title, street, house, flat, floo, comment, create_at');
            if($user_id){
                $this->where('user_id', $user_id);
            }
            $this
                ->join('cities', 'address.city_id=cities.id')
                ->orderBy('create_at', 'DESC');
    
            return $this->paginate($paginate);
        }

        return false;
    }

}