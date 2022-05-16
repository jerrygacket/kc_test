<?php

class DBWorker
{
    private static $_instance = null;

    private $db; // Ресурс работы с БД

    /*
     * Получаем объект для работы с БД
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new DBWorker();
        }
        return self::$_instance;
    }

    /*
     * Запрещаем копировать объект
     */
    private function __construct() {
        // Формируем строку соединения с сервером
        $connectString = 'mysql'
            . ':host=' . Config::get('db_host')
            . ';port=' . Config::get('db_port')
            . ';dbname=' . Config::get('db_base')
            . ';charset='. Config::get('db_charset') .';';
        $this->db = new PDO($connectString, Config::get('db_user'), Config::get('db_password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // возвращать ассоциативные массивы
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // возвращать Exception в случае ошибки
            ]
        );
    }

    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}

    private function makeWhere($where) {
        if (empty($where)) {
            return '';
        }
        $whereSets = [];
        foreach ($where as $key => $value) {
            $whereSets[] = $key . '=\'' . $value . '\'';
        }

        return ' WHERE ' . implode(' AND ', $whereSets);
    }

    private function makeSelect($select) {
        if (empty($select)) {
            return '*';
        }

        return implode(',', $select);
    }

    public function Query($query) {

        $q = $this->db->prepare($query);
        $q->execute();

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            Logger::Write($info[2]);
            return false;
        }

        return $q->fetch();
    }

    public function Select($table, $select = [], $where = []) {

        $query = 'SELECT ' . $this->makeSelect($select) . ' FROM ' . $table . $this->makeWhere($where);

        $q = $this->db->prepare($query);
        $q->execute();

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            Logger::Write($info[2]);
            return false;
        }

        if (empty($where)) {
            return $q->fetchAll();
        } else {
            return $q->fetch();
        }
    }

    public function SelectMany($table, $select = [], $where = []) {

        $query = 'SELECT ' . $this->makeSelect($select) . ' FROM ' . $table . $this->makeWhere($where);

        $q = $this->db->prepare($query);
        $q->execute();

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            Logger::Write($info[2]);
            return false;
        }

        return $q->fetchAll();
    }

    public function Insert($table, $object) {
        foreach ($object as $key => $value) {
            if ($value === NULL) {
                $object[$key] = 'NULL';
            }
        }
        $keys = array_keys($object);
        $columns = implode(',', $keys);
        $masks = ':' . implode(',:', $keys);

        $query = "INSERT INTO $table ($columns) VALUES ($masks)";
        echo $query;
        $q = $this->db->prepare($query);
        $q->execute($object);

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            print_r($info);
            Logger::Write($info[2]);
            return false;
        }

        return $this->db->lastInsertId();
    }

    public function Update($table, $object, $where) {
        $sets = array();

        foreach ($object as $key => $value) {
            $sets[] = "$key=:$key";
            if ($value === NULL) {
                $object[$key] = 'NULL';
            }
        }

        $sets_s = implode(',',$sets);
        $query = "UPDATE $table SET $sets_s" . $this->makeWhere($where);

        $q = $this->db->prepare($query);
        $q->execute($object);

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            Logger::Write($info[2]);
            return false;
        }

        return $q->rowCount();
    }

    public function Delete($table, $where) {

        $query = "DELETE FROM $table WHERE $where";
        $q = $this->db->prepare($query);
        $q->execute();

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            Logger::Write($info[2]);
            return false;
        }

        return $q->rowCount();
    }
}
