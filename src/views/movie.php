<?php
require_once __DIR__ . '/layout/head.php';
require_once __DIR__ . '/layout/header.php';
?>
<div class="content">
    <?php if (isset($_SESSION['fb'])) : ?>
        <div class="notification is-info">
            <strong>
                <?= $_SESSION['fb'];
                unset($_SESSION['fb']); ?>
            </strong>
        </div>
    <?php endif; ?>
    <div class="columns">
        <div class="column">
            <div class="card is-shadowless">
                <img src="/images/<?= $data['cover_image'] ?>" alt="<?= $data['name'] ?>">
            </div>
        </div>
        <div class="column">
            <div class="card is-shadowless">
                <h1 class="title has-text-grey-light">Movie Title: <?= $data['name'] ?></h1>
                <h4 class="has-text-grey-light">Genre: <?= $data['genre'] ?></h4>
                <h6 class="has-text-info">Price: <?= $data['price'] ?></h6>
            </div>
        </div>
    </div>
    <?php
    require_once __DIR__ . '/layout/footer.php';
    require_once __DIR__ . '/layout/foo.php';
    ?>