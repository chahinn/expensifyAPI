<?php

namespace Controllers;
trait LoggedInController {

    public function before_action_hook($params) {
        if(isset($_COOKIE['expensifyAuthToken'])) {
            return array($_COOKIE['expensifyAuthToken']);
        } else {
            echo $this->error_response("Not Authenticated", 401);
            die();
        }
    }

}