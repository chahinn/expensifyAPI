<?php
namespace Controllers;

class Login {
    use Controller;

    public function action($params) {
        if (!$this->validate_params($params, array("user_id", "user_secret"))) {
            return $this->error_response("Your username or password was not valid.", 401);
        }

        $partner = new \Expensify\Partner();
        $partner->name = "applicant";
        $partner->password = "d7c3119c6cdab02d68d9";
        $partner->user_id = $params['user_id'];
        $partner->user_secret = $params['user_secret'];
        $exp = new \Expensify\Expensify();

        try {
            http_response_code(201);
            $auth = $exp->authenticate($partner);
            setcookie("expensifyAuthToken", $exp->auth_token);
            return $auth;
        } catch (Exception $e) {
            return $this->error_response($e->getMessage());
        }
    }

}