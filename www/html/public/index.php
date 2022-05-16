<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$route = App::parseRoute($_SERVER['REQUEST_URI']);

switch ($route['route']) {
    case '/login.html':
    case '/':
        if (!User::isGuest()) {
            header('Location: /students.html');
        } else {
            echo file_get_contents('../pages/login.html');
        }
        break;
    case '/students.html':
        if (User::isGuest()) {
            header('Location: /login.html');
        } else {
            echo file_get_contents('../pages/students.html');
        }
        break;
    default:
        App::run(trim($route['route']));
}
