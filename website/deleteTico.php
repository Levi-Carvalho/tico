<?php
require "autoload.php";
use app\classes\session\Login;
use app\classes\entity\Tico;

Login::require_login();
if(isset($_GET['id']) && !empty($_GET['id'] && is_numeric($_GET['id']))) {
    if (isset($_SESSION['user'])){
        $tico = new Tico($_GET['id']);
        if($_SESSION['user']['id'] == $tico->getUserId()) {
            $tico->delete($_GET['id']);
        } else {
            die('isheeeee');
        }
    } else {
        die('hovuca');
    }
} else {
    echo "que q tu ta fazendo";
}
