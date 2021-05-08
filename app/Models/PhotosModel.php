<?php

namespace App\Models;

use CodeIgniter\Model;

class PhotosModel extends Model
{
    protected $table = 'photos';
    protected $allowedFields = ['url', 'camera_id'];

}
