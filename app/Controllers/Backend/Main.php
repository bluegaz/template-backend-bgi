<?php

namespace App\Controllers\Backend;

use CodeIgniter\Controller;

class Main extends Base
{
    public function index()
    {
        return view("{$this->class}View", ["class" => $this->class]);
    }
}
