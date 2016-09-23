<?php
namespace Controllers;
class CreateTransaction {
    use Controller;
    use LoggedInController;

    public function action($params, $user_token) {
        if (!$this->validate_params($params, array("amount", "currency", "merchant", "created_at"))) {
            return $this->error_response("Please make sure you set the amount, currency, merchant and created date", 400);
        }

        $exp = new \Expensify\Expensify();
        $exp->auth_token = $user_token;

        return $exp->add(
            $params['amount'],
            $params['currency'],
            $params['merchant'],
            $params['created_at']
        );
    }
}