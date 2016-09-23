<?php

// Controller Requirements
require('controllers/controller.php');
require('controllers/logged_in_controller.php');

// Controllers
require('controllers/home.php');
require('controllers/login.php');
require('controllers/list_transaction.php');
require('controllers/create_transaction.php');

class Router {

    // TODO: Move routing functionality into a trait so this class can be
    //       cleaned up

    var $extension_regex = '(\.(?P<extension>\w+))?';
    var $regex_suffix = '$';
    var $regex_prefix = '^';

    var $routes = array(
        '/'             => array('GET' => 'Controllers\Home'),
        '/login'        => array('POST' => 'Controllers\Login'),
        '/transactions' => array(
            'GET'  =>  'Controllers\ListTransaction',
            'POST' =>  'Controllers\CreateTransaction'
        )
    );

    public function route($verb, $path, $params) {
        foreach ($this->routes as $route => $verbs) {

            $route_regex = '!' .
                           $this->regex_prefix .
                           '(?P<route>' . $route . ')' .
                           $this->extension_regex .
                           $this->regex_suffix .
                           '!';

            preg_match($route_regex, $path, $matches);

            if (!isset($matches['extension'])) {$matches['extension'] = 'html';}

            if (isset($matches['route'])) {
                // Path Match
                foreach ($verbs as $verb_match => $controller) {
                    if ($verb == $verb_match) {
                        // Path & Verb Match
                        $controller_class = new ReflectionClass($controller);
                        $ctr = $controller_class->newInstance();
                        // Perform the work in the controller, then exit.
                        $ctr->perform_action($matches['extension'], $verb, $path, $params);
                        exit();
                    }
                }
            }
        }

        // We didn't match any path/verb combos, return a 404 error
        http_response_code(404);
        echo json_encode(array("error" => "404 not found"));
        die();
    }
}