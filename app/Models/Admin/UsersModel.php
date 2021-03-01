<?php
namespace App\Models\Admin;
use CodeIgniter\Model;
use App\Models\UserGroup;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name','surname','patronymic','email','phone','city_id','password','group'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    public function FindUser($type, $input){
        if($type && $input){
            $this->select('users.name as user_name, users.id as user_id, users_group.id as group_id, users_group.name as group_name, phone, create_at, surname, patronymic, email');
            $this->join('users_group', 'users.group=users_group.id');
            $this->like('users.' . $type . '', $input);
            return $this;
        }
        return false;
    }

    public function sortUser($type, $input)
    {
        if($type && $input){
            $this->select('users.name as user_name, users.id as user_id, users_group.id as group_id, users_group.name as group_name, phone, create_at, surname, patronymic, email');
            $this->join('users_group', 'users.group=users_group.id');
            $this->orderBy('users.' . $type . '', $input);
            return $this;

        }
        return false;
    }
    
    
    public function getUsers()
    {   
        $this->select('users.name as user_name, users.id as user_id, users_group.id as group_id, users_group.name as group_name, phone, create_at, surname, patronymic, email');
        $this->join('users_group', 'users.group=users_group.id');
        return $this;
    }
    
    public function GetUser($id){
        return $this->where('id', $id)->first();
    }

}