<?php
namespace Controllers;
trait Controller {

    public function perform_action($extension, $verb, $path, $params) {
        $filetype = $this->detect_filetype($extension);

        header('Content-Type: ' . $filetype);

        switch($filetype) {
        case 'application/json':
            echo json_encode($this->action($params));
            break;
        default:
            echo $this->action($params);
            break;
        }
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
}