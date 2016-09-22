<?php
require("partner.php");
require("utils.php");

class Expensify {

    var $base_url = "https://www.expensify.com/api?";
    var $auth_token = null;

    public function authenticate($partner) {

        $data = array(
            "partnerName"       => $partner->name,
            "partnerPassword"   => $partner->password,
            "partnerUserID"     => $partner->user_id,
            "partnerUserSecret" => $partner->user_secret,
            "command"           => "Authenticate",
            "useExpensifyLogin" => "false"
        );

        $endpoint = $this->base_url . http_build_query($data);
        try {
            $response = Utils::http_get($endpoint);
            $response = json_decode($response);
            $this->auth_token = $response->authToken;
            return $this;
        } catch (Exception $e) {
            switch($e->getCode())  {
                case 500:
                    throw new Exception("Cannot Login: Internal Server Error", 500);
            }
        }
    }

    public function get_all($return_json) {
        $data = array(
            "command" => "Get",
            "authToken" => $this->auth_token,
            "returnValueList" => "transactionList"
        );

        $endpoint = $this->base_url . http_build_query($data);
        $response = Utils::http_get($endpoint);
        if ($return_json) {
            return json_decode($response);
        } else {
            return $response;
        }
        return $response->transactionList;
    }

    public function add($amount, $currency, $merchant, $created_at) {
        $data = array(
            "command"   => "CreateTransaction",
            "authToken" => $this->auth_token,
            "created"   => $created_at,
            "amount"    => $amount,
            "currency"  => $currency,
            "merchant"  => $merchant
        );

        $endpoint = $this->base_url . http_build_query($data);

        $response = Utils::http_get($endpoint);
        return $response;
    }
}
