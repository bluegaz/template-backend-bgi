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
            'uuid' => 'uuid',
            'name'  => 'name',
            'email'  => 'email',
            'phone'  => 'phoneNumber',
            'address' => 'address',
            'avatar' => 'imageUrl',
        ];

        $fabricator = new \CodeIgniter\Test\Fabricator(App\Models\Test::class, $formatters, "id_ID");

        $fake = [
            "draw" => $_POST['draw'],
            "recordsTotal" => 23,
            "recordsFiltered" => 23,
            "data" => $fabricator->make(10),
        ];

        echo json_encode($fake);
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
