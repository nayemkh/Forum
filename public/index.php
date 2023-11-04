<?php

$viewsPath = __DIR__ . '/views/';

switch ($_SERVER['REQUEST_URI']) {
    case '' :
    case '/':
        require $viewsPath . 'home.php';
        break;
    case '/registration' :
        require $viewsPath . 'registration.php';
        break;
    default:
        require $viewsPath . '404.php';
        break;
}