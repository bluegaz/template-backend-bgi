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
        $payload = [
            "cond" => [
                "filter1" => $this->request->getPost("filter1"),
                "filter2" => $this->request->getPost("filter2"),
                "filter3" => $this->request->getPost("filter3"),
                "date_single" => $this->request->getPost("date_range"),
                "date_range" => $this->request->getPost("date_single"),
            ],
            "limit" => "{$this->request->getPost('start')}, {$this->request->getPost('length')}"
        ];

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
            "draw" => $this->request->getPost("draw"),
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
