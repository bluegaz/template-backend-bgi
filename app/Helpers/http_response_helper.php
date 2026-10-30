<?php

if (! function_exists('response')) {
    /**
     * Send a JSON response and stop the script.
     */
    function response(int $code, mixed $message, ?array $data = null): never
    {
        $output = [
            'code'    => $code,
            'message' => $message,
        ];

        if ($data !== null) {
            $output['data'] = $data;
        }

        $response = service('response');

        $response->setStatusCode($code)
            ->setJSON($output);

        $response->send();
        exit;
    }
}

if (! function_exists('clear_payload')) {
    /**
     * Remove empty values from the given payload.
     */
    function clear_payload(array $payload): array
    {
        foreach ($payload as $key => $value) {
            if ($value === '' || $value === null) {
                unset($payload[$key]);
            }
        }

        return $payload;
    }
}
