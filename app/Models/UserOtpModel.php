<?php

namespace App\Models;

use CodeIgniter\Model;

class UserOtpModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_otp';
    protected $protectFields    = false;
}
