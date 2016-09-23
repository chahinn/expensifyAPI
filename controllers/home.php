<?php
namespace Controllers;
class Home {
    use Controller;

    public function action($params) {
        return "Hello World";
    }
}