<?php

namespace App\Libraries;

class API
{
    private $response = [];

    public function call(string $req, string $method = "POST", array $body = null): bool
    {
        $url = config("app")->baseAPIURL . $req;

        $requestTime = date("Y-m-d\TH:i:sP");

        $headerOptions = array(
            "Content-Type:application/json",
            "key:" . config('app')->apiKey,
            "x-token:" . hash('sha256', "bgi_document_monitoring-$requestTime-541nt531y4"),
        );

        $payload['request_time'] = $requestTime;

        if (!empty($body)) {
            $payload["data"] = $data;
        }

        $payload = json_encode($payload);

        if (!$payload) {
            $this->setResponse(0, "Payload cannot be null");
            return false;            
        }

        $payloadLength = strlen($payload);
        $headerOptions[] = "Content-Length:$payloadLength";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerOptions);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (ENVIRONMENT !== 'development') {
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        }

        $exec = curl_exec($ch);

        $errNo = curl_errno($ch);
        $errMsg = curl_error($ch);

        curl_close($ch);

        if ($exec === FALSE) {
            $this->setResponse($errNo, $errMsg);
            return false;
        }

        $output = json_decode($exec, true);

        if (!$output) {
            $this->setResponse(0, "Invalid JSON format. Output: $exec");
            return false;
        }

        return $output;
    }
    
    private function setResponse(int $code, string $message, array $data = null)
    {
        $response = [
            'success' => $code === 200 ? true : false,
            'code' => $code,
            'message' => $message,
        ];
        
        if ($data != null) {
            $response['data'] = $data;
        }
        
        $this->response = $response;
    }

    public function getResponse($json = false)
    {
        if ($json) {
            return json_encode($this->response);
        }

        return $this->response;
    }
}
