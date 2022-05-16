<?php

class AuthController
{
    public function actionIndex(array $params = []): array
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                return $this->login($params);
            case 'DELETE':
                return $this->logout();
            default:
                throw new Exception('Bad request', 400);
        }
    }

    public function login(array $params = [])
    {
        $params = array_merge($params, json_decode(file_get_contents('php://input'), true));
        $result = ['success' => false];
        if (!empty($params['username'])) {
            $user = User::finByUserName($params['username']);

            $result['success'] = $user->login($params['password'] ?? '', !is_null($params['remember']));
        }

        return $result;
    }

    public function logout(): array
    {
        return ['success' => User::logout()];
    }
}