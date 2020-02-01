<?php require_once __DIR__ . '/../layout/head.php'; ?>
<div class="form-wrapper">
    <div class="form">
        <?php if (isset($_SESSION['fb']) && !empty($_SESSION['fb'])) : ?>
            <div class="notification is-info">
                <strong>
                    <?= $_SESSION['fb'];
                    unset($_SESSION['fb']); ?>
                </strong>
            </div>
        <?php endif; ?>
        <form action="/user/reset" method="post">
            <div class="control field">
                <input class="input" type="text" name="email" placeholder="Email" autofocus>
            </div>
            <div class="control field">
                <input class="input" type="password" name="password" placeholder="New password">
            </div>
            <div class="control field">
                <input class="input" type="password" name="confirm_password" placeholder="Confirm password">
            </div>
            <div class="control field">
                <div class="has-text-centered">
                    <button class="button is-info">Reset</button>
                </div>
            </div>
            <div class="control field">
                <p class="is-size-7 has-text-grey-light">
                    Back to <a href="/user/signin" class="has-text-grey-dark">signin</a> or <a href="/user/register" class="has-text-grey-dark">signup</a>
                </p>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../layout/foo.php'; ?>