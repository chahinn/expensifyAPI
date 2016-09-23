<?php

class Params {

    public function extract_path($get) {
        if (isset($get['__path'])) {
            return $get['__path'];
        } else {
            return "/";
        }
    }

    public function extract_params($post, $get) {
        function sanitize_param($param) {
            return filter_var($param, FILTER_SANITIZE_STRING);
        }
        return array_map("sanitize_param", array_merge($post, $get));
    }

}