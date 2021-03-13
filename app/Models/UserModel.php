<?php
namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name','surname','patronymic','email','phone','api','password'];
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


    public function getUsers(){
        $model_group = new UserGroup();
        $users = [];
        foreach ($this->findAll() as  $user) {
            $users[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'patronymic' => $user['patronymic'],
                'group' => $model_group->GetUserPermission($user['group']),
            ];
        }
        return $users;
    }

    public function GetUser($id){
        return $this->where('id', $id)->first();
    }



}
