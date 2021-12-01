<?php

namespace App\Libraries;

class API
{
    private $response = [];
    private $responseStatus;

    public function call(string $req, string $method = "POST", array $body = null): bool
    {
        $url = config("app")->baseAPIURL . $req;

        $requestTime = date("Y-m-d\TH:i:sP");

        $headerOptions = [
            "Content-Type:application/json",
            "key:" . config('app')->apiKey,
            "x-token:" . hash('sha256', "bgi_document_monitoring-$requestTime-541nt531y4"),
        ];

        $payload['request_time'] = $requestTime;

        if (!empty($body)) {
            if ($method == "POST") {
                $body['where'] = clear_payload($body['where']);
            }

            $payload["payload"] = $body;
        }
        
        $payload = json_encode($payload);

        if (!$payload) {
            $this->setResponse(500, "Payload cannot be null");
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

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errMsg = curl_error($ch);

        curl_close($ch);

        if ($exec === FALSE) {
            $this->setResponse($statusCode, $errMsg);
            return false;
        }

        $response = json_decode($exec, true);

        if (!$response) {
            $this->setResponse(500, "Invalid JSON format. Response: $exec");
            return false;
        }

        $this->setResponse($response['code'], $response['msg'], @$response['results']);

        return true;
    }

    private function setResponse(int $code, $message, array $data = null)
    {
        $this->responseStatus = $code === 200 ? true : false;

        $response = [
            'success' => $this->responseStatus,
            'code' => $code,
            'message' => $message,
        ];

        if ($data != null) {
            $response['results'] = $data;
        }

        $this->response = $response;
    }

    public function getResponse(bool $needValidation = true): array
    {
        if ($needValidation) {
            $this->responseValidation();
        }

        return $this->response;
    }

    public function responseValidation()
    {
        if ($this->responseStatus === false) {
            response($this->response['code'], $this->response['message']);
        }
    }
}
