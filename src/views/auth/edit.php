<?php
require_once __DIR__ . '/../layout/head.php';
require_once __DIR__ . '/../layout/header.php';
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
    <form action="/user/edit/<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="wrapper-flex align-right">
            <a class="button is-danger w-item" href="/user/delete/<?= $data['id'] ?>">Delete accout</a>
            <button class="button is-info w-item">Update profile</button>
        </div>
        <div class="columns">
            <div class="column">
                <div class="card is-shadowless">
                    <img src="/images/<?= $data['avatar'] ?>" alt="<?= $data['name'] ?>">
                </div>
            </div>
            <div class="column">
                <div class="card is-shadowless">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <div class="control field">
                        <input class="input" type="file" name="avatar">
                    </div>
                    <div class="control field">
                        <input class="input" type="text" name="name" value="<?= $data['name'] ?>" placeholder="Name">
                    </div>
                    <div class="control field">
                        <input class="input" type="text" name="email" value="<?= $data['email'] ?>" placeholder="Email">
                    </div>
                    <div class="control field">
                        <input class="input" type="text" name="username" value="<?= $data['username'] ?>" placeholder="Username">
                    </div>
                    <article class="message is-warning">
                        <div class="message-header">
                            <p>Notice!</p>
                        </div>
                        <div class="message-body">
                            <p>If you're not changing the password, input and confirm your current password to save changes.</p>
                        </div>
                    </article>
                    <div class="control field">
                        <input class="input" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="control field">
                        <input class="input" type="password" name="confirm_password" placeholder="Confirm password">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
require_once __DIR__ . '/../layout/footer.php';
require_once __DIR__ . '/../layout/foo.php';
?>