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
        <form action="/user/signin" method="post">
            <div class="control field">
                <input class="input" type="text" name="username" placeholder="Username" autofocus>
            </div>
            <div class="control field">
                <input class="input" type="password" name="password" placeholder="Password">
            </div>
            <div class="control field has-text-right">
                <p class="is-size-7 has-text-grey-light">Forgot password ? <a href="/user/reset" class="has-text-grey-dark">reset</a></p>
            </div>
            <div class="control field">
                <label class="checkbox">
                    <input type="checkbox" name="persist" value="1">
                    <span class="has-text-grey-light">Remember me</span>
                </label>
            </div>
            <div class="control field">
                <div class="has-text-centered">
                    <button class="button is-info">Submit</button>
                </div>
            </div>
            <div class="control field">
                <p class="is-size-7 has-text-grey-light">Don't have a account ? <a href="/user/register" class="has-text-grey-dark">register</a></p>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../layout/foo.php'; ?>