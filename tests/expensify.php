<?php

    require_once("../expensify.php");

    $exp = new Expensify();

    // Does the Cookie Exist?
    //if (isset($_COOKIE['expensifyAuthToken'])) {
     //   $exp->auth_token = $_COOKIE['expensifyAuthToken'];
//    } else {
        // TODO: Show login form somehow
        // Build Expensify Object & Authenticate

        $partner = new Partner();
        $partner->name = "applicant";
        $partner->password = "d7c3119c6cdab02d68d9";
        $partner->user_id = "expensifytest@mailinator.com";
        $partner->user_secret = "hire_me";

        $exp = new Expensify();
        try {
            $exp->authenticate($partner);
            setcookie("expensifyAuthToken", $exp->auth_token);
        } catch (Exception $e) {
            $error_response = json_encode(array("error" => $e->getMessage()));
            die($error_response);
        }
 //   }

//print_r($exp->get_all(false));






//$get_all = $exp->authenticate($partner)->get_all(false);
//print_r($get_all);

$add = $exp->authenticate($partner)
     ->add("-999", "USD", "FarmGeek", "2016-11-01");

print_r($add);

   die();