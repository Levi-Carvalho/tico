<?php
require "autoload.php";
use app\classes\session\Login;
use app\classes\entity\User;

if(
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password']) && !empty($_POST['password'])
    ) {
        $user = (new User())->getUserByEmail($_POST['email'])->fetch(PDO::FETCH_OBJ);
        if (password_verify($_POST['password'], $user->password)) {
            Login::login($user);
            exit;
        } else {
            echo "Cai em cima do comumelo";
        }
    }

include __DIR__ . "/app/includes/open-html-head.php";
include __DIR__ . "/app/includes/open-body-container.php";
include __DIR__ . "/app/includes/header.php";
include __DIR__ . "/app/includes/form-login.php";
include __DIR__ . "/app/includes/footer.php";

?>