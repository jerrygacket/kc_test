<?php

class App
{
    public const ALLOW_ACTIONS = [
        '/auth',
    ];

    public static function run($route)
    {
        if (User::isGuest() && !in_array($route, self::ALLOW_ACTIONS)) {
            header('Status: 401');
            echo json_encode(['result' => 'Not authorized']);
            return false;
        }
        $parts = array_values(array_filter(explode('/', $route)));
        $controllerName = ucfirst($parts[0] ?? 'auth') . 'Controller';
        $action = empty($parts[1]) ? 'index' : $parts[1];
        $action = 'action' . ucfirst($action);

        if (class_exists($controllerName) && method_exists($controllerName, $action)) {
            $controller = new $controllerName();
            echo json_encode(['result' => $controller->$action($_REQUEST)]);
            return true;
        } else {
            header('Status: 400');
            echo json_encode(['result' => 'Bad request']);
            return false;
        }
    }

    public static function parseRoute($route): array
    {
        $parts = explode('?', $route);

        return [
            'route' => $parts[0] ?? '/',
            'params' => $parts[1] ?? null
        ];
    }
}