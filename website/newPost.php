<?php

require "autoload.php";
use app\classes\entity\Tico;
use app\classes\session\Login;

Login::require_login();

if(isset($_POST['content']) && !empty($_POST['content'])) {
    $post = new Tico();
    $post->setUserId($_SESSION['user']['id']);
    $post->setSourceId(isset($_POST['source_id']) ? $_POST['source_id'] : null);
    $post->setContent(htmlentities($_POST['content']));
    if($post->post()) {
        header('location: index.php?status=success');
    } else {
        header('location: index.php?status=failed');
    };
} else {
    header('location: index.php?status=failed');
}

