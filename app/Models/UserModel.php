<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user_registration';

    protected $allowedFields = [
        'id',
        'name',
        'l_name',
        'photo',
        'email',
        'password',
        'phone',
        'message',
        'created_at',
        'modified_at'
    ];
}
