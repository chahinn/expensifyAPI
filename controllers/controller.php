<?php
namespace Controllers;
trait Controller {

    public function perform_action($extension, $verb, $path, $params) {
        $filetype = $this->detect_filetype($extension);

        header('Content-Type: ' . $filetype);

        switch($filetype) {
        case 'application/json':
            echo json_encode($this->action_wrapper($params));
            break;
        default:
            echo $this->action_wrapper($params);
            break;
        }
    }

    private function action_wrapper($params)  {
        $args = array($params);
        if (method_exists($this, 'before_action_hook')) {
            $args = array_merge($args, $this->before_action_hook($params));
        }

        return call_user_func_array(
            array($this, 'action'),
            $args
        );
    }

    private function detect_filetype($extension) {
        switch ($extension) {
        case 'json':
            return "application/json";
        case 'html':
            return "text/html";
        default:
            return "text/html";
        }
    }

    protected function validate_params($params, $checks)  {
        foreach ($checks as $check) {
            if (!isset($params[$check])) {
                return false;
            }
        }
        return true;
    }

    protected function error_response($msg, $statusCode = 500) {
        http_response_code($statusCode);
        return array('error' => $msg);
    }
}