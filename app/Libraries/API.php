<?php

namespace App\Libraries;

class API
{
    public function call()
    {
        $url = config("app")->baseAPIURL;

        $this->setLogMessage("Start processing $action");

        $payload = array(
            "entity" => $this->entity,
            "branch" => $this->branch,
            "subbranch" => $this->subbranch,
        );

        $ch = curl_init($url);

        $headerOptions = array(
            "Content-Type:application/json",
            "key:" . md5("saris_internal_" . date("Y-m-d")),
        );

        if (!empty($data)) {
            $payload["data"] = $data;
        }

        $payload = json_encode($payload);

        if (!$payload) {
            $this->setLogMessage("Fail to convert data to JSON", TRUE);
            return false;
        }

        $dataLength = strlen($payload);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $headerOptions[] = "Content-Length:$dataLength";

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerOptions);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (!$debug) {
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        }

        $exec = curl_exec($ch);

        $errNo = curl_errno($ch);
        $curlErrMsg = curl_error($ch);

        curl_close($ch);

        if ($exec === FALSE) {
            $this->setLogMessage("cURL err: ($errNo) $curlErrMsg", TRUE);
            return false;
        }

        $this->setLogMessage("$action successfuly executed");

        $output = json_decode($exec, true);

        if (!$output) {
            $this->setLogMessage("Invalid JSON format. Output: $exec", TRUE);
            return false;
        }

        return $output;
    }
}
