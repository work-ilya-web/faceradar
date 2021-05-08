<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientsPhotosModel extends Model
{
    protected $table = 'clients_photos';
    protected $allowedFields = ['url', 'clients_id', 'visits_id'];

}
