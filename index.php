<?php

    require('lib/router.php');
    require('lib/params.php');

    $param_extractor = new Params();
    $params = $param_extractor->extract_params($_POST, $_GET);
    $path   = $param_extractor->extract_path($_GET);
    $verb   = strtoupper($_SERVER['REQUEST_METHOD']);

    $router = new Router();
    $router->route($verb, $path, $params);