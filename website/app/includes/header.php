<?php

use app\classes\session\Login;

?>
        <header class="header">
            <div class="logo">Tico-tico</div>
            <nav>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Lojinha</a></li>
                </ul>
            </nav>
            <div class="profile">

            <?php if(Login::isLogged()): ?>
                <div>
                    <a href="logout.php">Sair</a>
                    <img 
                        src="uploads/profile-img/<?=$_SESSION['user']['username']?>.jpg"
                        width="50px" alt=""
                        style="border-radius: 50px; box-shadow: 0 0 8px;">
                </div>
            <?php else:?>
                    <div class="profile-img">
                        <button class="login-button"><a href="login.php">Login</a></button>
                        <button class="register-button"><a href="sign-up.php">Cadastrar</a></button>
                        <!-- <img src="assets/img/botan.jpg" alt="" width="50px" style="border-radius: 100px;"> -->
                    </div>
            <?php endif?>

            </div>
        </header>