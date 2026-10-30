<?php

namespace App\Controllers\Backend;

class Main extends Base
{
    public function index(): string
    {
        return view("{$this->class}View", ['class' => $this->class]);
    }
}
