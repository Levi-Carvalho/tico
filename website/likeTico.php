<?php

require "autoload.php";

use app\classes\session\Login;
use app\classes\entity\Interaction;

Login::require_login();
$a = new Interaction($_GET['tico_id'], $_SESSION['user']['id'], $_GET['action']);
echo json_encode($a->interact());