<?php

namespace app\classes\entity;
use app\classes\database\Database;
use app\classes\entity\Interaction;
use ErrorException;
use DateTimeImmutable;
use PDO;

class Tico {
    private $id;
    private $user_id;
    private $type;
    private $source_id;
    private $content;
    private $date;

    public function __construct($id = '')
    {
        if(!empty($id)){
            $a = $this->getPosts("id=".$id)->fetch(PDO::FETCH_OBJ);
            echo "id = ".$id." 00";
            $this->id = $a->id;
            $this->user_id = $a->user_id;
            $this->type = $a->type;
            $this->source_id = $a->source_id;
            $this->content = $a->content;
            $this->date = $a->date;
        }
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setSourceId($source_id) {
        $this->source_id = $source_id;
    }

    private function setType() {
        $this->type = empty($this->source_id) ? "original" : "reply";
    }

    private function setDate() {
        date_default_timezone_set('UTC');
        $date = new DateTimeImmutable();
        $this->date = date_format($date, 'Y-m-d H:i:s');
    }

    public function post(){
        try {
            $this->setDate();
            $this->settype();
            return (new Database('tico'))->insert(
                [
                    "content" => $this->content,
                    "user_id" => $this->user_id,
                    "source_id" => $this->source_id,
                    "type" => $this->type,
                    "date" => $this->date,
                ]
            );
        } catch (ErrorException $e) {
            echo $e->getMessage();
        }
    }

    public function getPosts($where = '', $order = '', $limit = '', $fields = '*'){
        $pquery =
        "SELECT 
        tico.id, tico.content, tico.date, tico.user_id,
        user.name, user.username, user.email,
        IFNULL(l.count, 0) as likes,
        IFNULL(d.count, 0) as dislikes,
        IFNULL(s.count, 0) as saves,
        IFNULL(sh.count, 0) as shares,

        CASE WHEN likes.user_id IS NOT NULL THEN 1 ELSE 0 END as user_liked,
        CASE WHEN dislike.user_id IS NOT NULL THEN 1 ELSE 0 END as user_disliked,
        CASE WHEN save.user_id IS NOT NULL THEN 1 ELSE 0 END as user_saved,
        CASE WHEN share.user_id IS NOT NULL THEN 1 ELSE 0 END as user_shared

        FROM tico
        INNER JOIN user ON user.id = tico.user_id
        LEFT JOIN (
            SELECT tico_id, COUNT(*) as count 
            FROM likes 
            GROUP BY tico_id
        ) l ON tico.id = l.tico_id
        LEFT JOIN (
            SELECT tico_id, COUNT(*) as count 
            FROM dislike 
            GROUP BY tico_id
        ) d ON tico.id = d.tico_id
        LEFT JOIN (
            SELECT tico_id, COUNT(*) as count 
            FROM save 
            GROUP BY tico_id
        ) s ON tico.id = s.tico_id
        LEFT JOIN (
            SELECT tico_id, COUNT(*) as count 
            FROM share 
            GROUP BY tico_id
        ) sh ON tico.id = sh.tico_id
        LEFT JOIN likes ON tico.id = likes.tico_id AND likes.user_id = ". $_SESSION['user']['id'] ."
        LEFT JOIN dislike ON tico.id = dislike.tico_id AND dislike.user_id = ". $_SESSION['user']['id'] ."
        LEFT JOIN save ON tico.id = save.tico_id AND save.user_id = ". $_SESSION['user']['id'] ."
        LEFT JOIN share ON tico.id = share.tico_id AND share.user_id = ". $_SESSION['user']['id']."
        ORDER BY DATE DESC";

        return (new Database('tico'))->select($where, $order, $limit, $fields, $pquery);
    }

    public function delete(){
        $d = new Interaction($this->id, $_SESSION['user']['id']);
        $d->undo('likes')->rowCount();
        $d->undo('dislike')->rowCount();
        $d->undo('save')->rowCount();
        $d->undo('share')->rowCount();
        return (new Database('tico'))->delete("id=".$this->id);
    }
}
