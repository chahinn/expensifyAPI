<?php
namespace Controllers;
class Home {
    use Controller;

    public function action($params) {
        $view_conn = fopen("views/home.html", "r") or die("Unable to open view!");
        $view = fread($view_conn,filesize("views/home.html"));
        fclose($view_conn);
        return $view;
    }
}