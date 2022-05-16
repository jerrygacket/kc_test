<?php

class UsersController
{
    public function actionIndex(array $params = []): array
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->students($params);
            default:
                header('Status: 400');
                echo json_encode(['result' => 'Bad request', 'success' => true]);
                return [];
        }
    }

    public function students(array $params = []): array
    {
        return ['success' => true, 'result' => Students::findAll($params)];
    }
}