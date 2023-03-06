<?php

use app\classes\entity\Tico;

$post = new Tico();
$ticos = $post->getPosts()->fetchAll(PDO::FETCH_OBJ);
?>
<div class="ticos">
<?php foreach ($ticos as $key => $tico) : ?>
<div class="tico">
<section>
    <div class="author">
        <div class="profile">
            <img src="uploads/profile-img/<?= $tico->username ?>.jpg" alt="" height="100px">
        </div>
    </div>
    <div class="content">
        <div class="post-options-bar">
            <p>
                <b><?= $tico->name ?></b>
                <br>
                <small>@<?= $tico->username ?>
                </small>
            </p>
            <div class="post-options"><!--...-->
                <ul>
                    <li><a href="">...</a></li>
                    <?php if($_SESSION['user']['id'] == $tico->user_id):?>
                    <li><a class="delete" href="deleteTico.php?id=<?=$tico->id?>">excluir</a></li>
                    <?php endif ?>
                    <li><a href="">denunciar</a></li>
                </ul>
            </div>
        </div>
        <p class="content-text">
            <?= $tico->content ?>
        </p>
    </div>
</section>
<div class="interactions">
    <button class="interaction <?=$tico->user_liked ? 'active' : ''?>">
        <a href="likeTico.php?
                user_id=<?= $_SESSION['user']['id'] ?>&
                tico_id=<?= $tico->id ?>&
                action=likes">
                <span class="likes"><?= $tico->likes?></span> &#128077;
        </a>
    </button>
    <button class="interaction <?=$tico->user_disliked ? 'active' : ''?>">
        <a href="likeTico.php?
                user_id=<?= $_SESSION['user']['id'] ?>&
                tico_id=<?= $tico->id ?>&
                action=dislike">
                <span class="dislikes"><?= $tico->dislikes?></span> &#128078;
        </a>
    </button>
    <button class="interaction <?=$tico->user_saved ? 'active' : ''?>">
        <a href="likeTico.php?
                user_id=<?= $_SESSION['user']['id'] ?>&
                tico_id=<?= $tico->id ?>&
                action=save">
                <span><?= $tico->saves?></span> &#128190;
        </a>
    </button>
    <button class="interaction <?=$tico->user_shared ? 'active' : ''?>" style="padding-top:0 ;">
        <a href="likeTico.php?
                user_id=<?= $_SESSION['user']['id'] ?>&
                tico_id=<?= $tico->id ?>&
                action=share">
                <span><?= $tico->shares?></span>
            <img style="position: relative; top: 4px;" width="20px" src="assets/svg/share_icon3.svg" alt="">
        </a>
    </button>
    <div class="date">
        <small>
            <?= $tico->date ?>
        </small>
    </div>
</div>
</div>
<?php endforeach; ?>
<?php if (count($ticos) == 0) : ?>
    <div class="footer"> <!-- parô com os julgamentos -->
        <div>
            <p style="text-align: center;"> Nenhum tico encontrado.</p>
        </div>
    </div>
<?php else : ?>
    <div class="footer"> <!-- parô com os julgamentos -->
        <div>
            <p style="text-align: center;"> Não há mais ticos.</p>
        </div>
    </div>
<?php endif; ?>

</div>

<script src="app/scripts/interactions.js"></script>
