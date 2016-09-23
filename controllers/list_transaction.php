<?php
namespace Controllers;
class ListTransaction {
    use Controller;
    use LoggedInController;

    public function action($params, $user_token) {
        $exp = new \Expensify\Expensify();
        $exp->auth_token = $user_token;
        return $exp->get_all();
    }
}