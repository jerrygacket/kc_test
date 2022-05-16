<?php

class Students
{
    public const PAGE_SIZE = 5;
    public const DEFAULT_PAGE = 1;

    public static function getTable(): string
    {
        return 'students';
    }

    public static function findAll(array $params = []): array
    {
        $db = DBWorker::getInstance();

        $result = $db->SelectMany(self::getTable());

        $page = (int) ($params['page'] ?? self::DEFAULT_PAGE);
        $perPage = (int) ($params['per-page'] ?? self::PAGE_SIZE);

        $data = array_slice(
            $result,
            intval(($page - 1) * $perPage),
            $perPage
        );

        $meta = [
            'page' => $page,
            'per-page' => $perPage,
            'total' => count($result),
            'pages' => ceil(count($result) / $perPage),
        ];

        return compact('data', 'meta');
    }
}