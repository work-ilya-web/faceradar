<?php
namespace App\Models\Admin;
use CodeIgniter\Model;
class AuthModel extends Model
{
    protected $table = 'users_main';
    protected $allowedFields = ['name','surname','patronymic','email','phone','city_id','password'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
}