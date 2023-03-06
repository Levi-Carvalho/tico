<?php

namespace app\classes\database;
use PDO;
use PDOException;

class Database {
    private $connection;
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
        try {
            $this->connection = new PDO('mysql:dbname=ticotico;host=db', 'root', 'rroott');
        } catch (PDOException $e) {
            echo 'UUUUUUEPAAAAAA'.$e->getMessage();
        }
    }
    
    private function execute($query, $params = []) {
        try {
            $st = $this->connection->prepare($query);
            $st->execute($params);
            return $st;
        } catch (PDOException $e) {
            echo "ain deu erro no execute do Database: ".$e->getMessage();
        }
    }

    public function insert($values = []) {
        $keys = array_keys($values);
        $values = array_values($values);
        $query = 'INSERT INTO '.  $this->table.' ('. implode(',', $keys) .') VALUES ('. implode(',', array_pad([], count($keys), '?')) .');';

        return $this->execute($query, $values);
    }

    public function delete($where) {
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
        // echo $query;
        return $this->execute($query);
    }

    public function select($where = '', $order = '', $limit = '', $fields = '*', $pquery = '') {
        if (!empty($where)) {
            $fields = $fields;
            $where = empty($where) ? '' : ' WHERE ' . $where;
            $order = empty($order) ? '' : ' ORDER BY ' . $order;
            $limit = empty($limit) ? '' : ' LIMIT ' . $limit;
            $query = 'SELECT '. $fields .' FROM '. $this->table . $where . $order . $limit;
        } else {
            $query = $pquery;
        }
        return $this->execute($query);
    }
}