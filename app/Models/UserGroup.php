<?php


namespace App\Models;
use CodeIgniter\Model;

class UserGroup extends Model {
    protected $table = 'users_group';
    protected $allowedFields = ['name', 'permission'];

    public function GetUserPermission($permission_id){
        return $this->where('permission', $permission_id)->first();
    }

}