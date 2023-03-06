<?php

namespace app\classes\entity;
use app\classes\database\Database;
use ErrorException;
use DateTimeImmutable;

class User {
    private $id;
    private $name;
    private $username;
    private $password;
    private $email;
    private $creation_date;

    public function getUserByEmail($email) {
        return (new Database('user'))->select("email='".$email."'");
    }

    private function setDate() {
        date_default_timezone_set('UTC');
        $date = new DateTimeImmutable();
        $this->creation_date = date_format($date, 'Y-m-d H:i:s');
    }

    public function createUser(){
        $this->setDate();
        return (new Database('user'))->insert(
            [
                "name" => $this->name,
                "username" => $this->username,
                "email" => $this->email,
                "password" => $this->password,
                "creation_date" => $this->creation_date,
            ]
        );
    }

    public function getPosts($where = '', $order = '', $limit = '', $fields = '*'){
        return (new Database('tico'))->select($where, $order, $limit, $fields);
    }
}