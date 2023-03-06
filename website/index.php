<?php

require "autoload.php";
use app\classes\session\Login;

Login::require_login();

// $post->setUserId(10);
// $post->setSourceId('10');
// $post->setContent("a b c d e f g h e j k l m n o p q r s t u v w x y z é o abc");
// $post->post();


// echo "<pre>";
// print_r($post->getPosts('','id DESC')->fetchAll(PDO::FETCH_OBJ));
// echo "</pre>";

include __DIR__ . "/app/includes/open-html-head.php";
include __DIR__ . "/app/includes/open-body-container.php";
include __DIR__ . "/app/includes/header.php";
include __DIR__ . "/app/includes/tico-editor.php";
include __DIR__ . "/app/includes/time-line-ticos.php";
include __DIR__ . "/app/includes/footer.php";

?>

        



        
    </div>
</body>
</html>