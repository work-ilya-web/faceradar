<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Models\UserGroup;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name','surname','patronymic','email','companies_id','password','group', 'api'];
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
            $this->select('users.name as user_name, users.id as user_id, companies.name as company_name, companies.id as company_id, users_group.id as group_id, users_group.name as group_name,  create_at, surname, patronymic, email');
            $this->join('users_group', 'users.group=users_group.id');
            $this->join('companies', 'users.companies_id=companies.id');
            $this->like('users.' . $type . '', $input);
            return $this;
        }
        return false;
    }

    public function sortUser($type, $input)
    {
        if($type && $input){
            $this->select('users.name as user_name, users.id as user_id, users_group.id as group_id, users_group.name as group_name,  create_at, surname, patronymic, email');
            $this->join('users_group', 'users.group=users_group.id');
            $this->orderBy('users.' . $type . '', $input);
            return $this;

        }
        return false;
    }


    public function getUsers()
    {
        $this->select('users.name as user_name, users.id as user_id, companies.name as company_name, companies.id as company_id, users_group.id as group_id, users_group.name as group_name,  create_at, surname, patronymic, email');
        $this->join('users_group', 'users.group=users_group.id');
        $this->join('companies', 'users.companies_id=companies.id');
        return $this;
    }

    public function getReceptions()
    {
        $this->select('users.name as user_name, users.id as user_id, companies.name as company_name, companies.id as company_id, users_group.id as group_id, users_group.name as group_name,  create_at, surname, patronymic, email');
        $this->join('users_group', 'users.group=users_group.id');
        $this->join('companies', 'users.companies_id=companies.id');
        $this->where('group', '3');
        return $this;
    }

    public function GetUser($id){
        return $this->where('id', $id)->first();
    }

}
