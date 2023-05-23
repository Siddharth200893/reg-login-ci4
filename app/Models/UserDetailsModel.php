<?php

namespace App\Models;

use CodeIgniter\Model;

class UserDetailsModel extends Model
{
    protected $table = 'user_details';

    protected $allowedFields = [
        'id',

        'phone',
        'message',

        'file_name',
        'file_type',
        'created_at',
        'modified_at',
    ];
}
