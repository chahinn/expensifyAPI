<?php
namespace Expensify;
require("expensify_partner.php");
require("expensify_utils.php");

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
            return $response;
        } catch (Exception $e) {
            switch($e->getCode())  {
                case 500:
                    throw new Exception("Cannot Login: Internal Server Error", 500);
            }
        }
    }

    public function get_all() {
        $data = array(
            "command"         => "Get",
            "authToken"       => $this->auth_token,
            "returnValueList" => "transactionList"
        );

        $endpoint = $this->base_url . http_build_query($data);
        $response = Utils::http_get($endpoint);
        return json_decode($response);
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

        $response = json_decode(Utils::http_get($endpoint));
        return $response;
    }
}
