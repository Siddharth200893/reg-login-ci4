<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    protected $table = 'add_business';

    protected $allowedFields = [
        'id',
        'name',
        'user_id',
        'address',
        'phone',
        'email',
        'l_img_name',
        'l_img_type',
        'g_img_name',
        'g_img_type',
        'created_at	',
        'modified_at',

    ];
}
