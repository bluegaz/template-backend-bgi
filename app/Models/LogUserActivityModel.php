<?php

namespace App\Models;

use CodeIgniter\Model;

class LogUserActivityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'log_user_activities';
    protected $returnType       = 'array';
    protected $protectFields    = false;
}
