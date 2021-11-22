<?php

namespace App\Controllers\Backend;

use App\Libraries\API;

class MenuXYZ extends Base
{
    public function index()
    {
        // $API = new API();

        $data['class'] = $this->class;
        return view("{$this->class}/{$this->class}ListView", $data);
    }

    public function list()
    {        
        $formatters = [
            'id' => 'uuid',
            'name'  => 'name',
            'email'  => 'email',
            'phone'  => 'phoneNumber',
            'address' => 'address',
            'avatar' => 'imageUrl',
        ];

        $fabricator = new \CodeIgniter\Test\Fabricator(App\Models\Test::class, $formatters, "id_ID");

        echo json_encode($fabricator->make(23));
    }

    public function form($act)
    {

    }

    public function save()
    {

    }

    public function update($id)
    {

    }

    public function delete($id)
    {

    }
}
