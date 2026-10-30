<?php

namespace App\Controllers\Backend;

class MenuXYZ extends Base
{
    public function index(): string
    {
        $data['class'] = $this->class;

        return view("{$this->class}/{$this->class}ListView", $data);
    }

    public function list(): void
    {
        $payload = [
            'where' => [
                'nik'       => $this->request->getPost('nik'),
                'is_active' => $this->request->getPost('status'),
            ],
            'limit' => [
                'start'  => (int) $this->request->getPost('start'),
                'length' => (int) $this->request->getPost('length'),
            ],
        ];

        $this->api->call('users', 'POST', $payload);

        $res = $this->api->getResponse();

        $recordTotal = 0;
        $recoredFiltered = 0;
        $data = [];

        if (isset($res['results'])) {
            $res = $res['results'];

            $recordTotal = $res['record']['total'];
            $recoredFiltered = $res['record']['filtered'];
            $data = $res['data'];
        }

        $fake = [
            'draw'            => $this->request->getPost('draw'),
            'recordsTotal'    => $recordTotal,
            'recordsFiltered' => $recoredFiltered,
            'data'            => $data,
        ];

        echo json_encode($fake);
    }

    public function form(string $act, ?string $id = null): string
    {
        $data['act'] = $act;
        $data['class'] = $this->class;

        if ($act === 'e') {
            if ($id === null || ! is_numeric($id)) {
                response(400, 'ID tidak boleh kosong');
            }

            $payload = ['where' => ['id' => $id]];

            $this->api->call('users', 'POST', $payload);

            $res = $this->api->getResponse();

            if (! isset($res['results'])) {
                response($res['code'], $res['message']);
            }

            $data += $res['results']['data'][0];
        }

        return view("{$this->class}/{$this->class}FormView", $data);
    }

    public function save(): void
    {
        $post = $this->request->getPost();

        $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);

        $payload[] = $post;

        $this->api->call('users', 'PUT', $payload);

        $this->api->responseValidation();

        response(200, null);
    }

    public function update(string $id): void
    {
        $payload = $this->request->getPost();

        $this->api->call("users/{$id}", 'PUT', $payload);

        $this->api->responseValidation();

        response(200, null);
    }

    public function delete(string $id): void
    {
        $this->api->call("users/{$id}", 'DELETE');

        $this->api->responseValidation();

        response(200, null);
    }
}
