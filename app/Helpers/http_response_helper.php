<?php

use CodeIgniter\HTTP\Response;

if (!function_exists('response')) {

    function response(int $code, $message, array $data = null)
    {
        $output = [
            'code' => $code,
            'message' => $message
        ];

        if ($data != null) {
            $output['data'] = $data;
        }

        $response = service('response');

        // if ($cache === true) {
        //     $response->setCache([
        //         'max-age'  => 21600,
        //         's-maxage' => 86400,
        //         'etag'     => 'test'
        //     ]);
        // }

        $response->setStatusCode($code)
            ->setJSON($output);

        $response->send();
        exit;
    }
}

if (!function_exists('clear_payload')) {

    function clear_payload(array $payload)
    {
        foreach ($payload as $key => $value) {
            
            if ($value === '' || $value === null) {
                unset($payload[$key]);
            }
        }

        return $payload;
    }
}
