<?php

namespace App\Models;

use CodeIgniter\Model;

class CompaniesModel extends Model
{
    protected $table = 'companies';
    protected $allowedFields = ['name', 'address','camera_id', 'status'];



}
