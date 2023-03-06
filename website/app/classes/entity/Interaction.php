<?php

namespace app\classes\entity;

use app\classes\database\Database;
use DateTimeImmutable;

class Interaction
{
    private $user_id;
    private $tico_id;
    private $action;
    private $status = array(
        "status" => "success",
        "action" => "", 
        "action_type" => "increase",    # increase, decrease 
        "undid_oposite" => false,        # yes, no
        "already_did" => false,          # yes, no
    );

    public function __construct($tico_id, $user_id, $action ='')
    {
        $this->tico_id = $tico_id;
        $this->user_id = $user_id;
        $this->action = $action;
    }

    private function setDate()
    {
        date_default_timezone_set('UTC');
        $date = new DateTimeImmutable();
        return date_format($date, 'Y-m-d H:i:s');
    }

    private function alreadyDid($action = '')
    {
        $action = empty($action) ? $this->action : $action;
        $a = (new Database($action))->select("tico_id=" . $this->tico_id . " AND user_id=" . $this->user_id);
        if (!($a->rowCount() > 0)) {
            return true;
        }
        $this->status['already_did'] = true;
        $this->status['action_type'] = 'decrease';
        return false;
    }
    
    private function authenticate()
    {
        if (is_numeric($this->tico_id) && is_numeric($this->user_id)) {
            if ($_SESSION['user']['id'] == $this->user_id)
                return true;
        }
        $this->status['status'] = 'failed';
        return false;
    }

    public function interact()
    {
        if ($this->authenticate()) {
            switch ($this->action) {
                case 'likes':
                    $this->status['action'] = 'like';
                    if($this->undo('dislike')->rowCount() > 0){
                        $this->status['undid_oposite'] = true;}
                    $this->alreadyDid() ? $this->do() : $this->undo();
                    break;

                case 'dislike':
                    $this->status['action'] = 'dislike';
                    if($this->undo('likes')->rowCount() > 0){
                        $this->status['undid_oposite'] = true;}
                    $this->alreadyDid() ? $this->do() : $this->undo();
                    break;

                default:
                    $this->alreadyDid() ? $this->do() : $this->undo();
                    break;
            }
        }

        return $this->status;
    }

    private function do($action = '')
    {
        $action = empty($action) ? $this->action : $action;
        return (new Database($action))->insert(
            [
                "user_id" => $this->user_id,
                "tico_id" => $this->tico_id,
                "date" => $this->setDate(),
            ]
        );
    }

    public function undo($action = '', $id = '')
    {
        $action = empty($action) ? $this->action : $action;
        $where = empty($id) ? 
        "tico_id=" . $this->tico_id . " AND user_id=" . $this->user_id
        : "id=".$id;
        return (new Database($action))->delete($where);
    }
}
