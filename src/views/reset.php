<?php require_once __DIR__ . '/layout/head.php'; ?>
<form action="/user/reset" method="POST">
    <div class="container-half">
        <div class="input-field">
            <input id="email" type="text" name="email" class="validate" autofocus>
            <label for="email">Email</label>
        </div>
        <div class="input-field">
            <input id="newPassword" type="password" name="password" class="validate">
            <label for="newPassword">New password</label>
        </div>
        <div class="input-field">
            <input id="confirmPassword" type="password" name="confirm_password" class="validate">
            <label for="confirmPassword">Confirm password</label>
        </div>
        <div class="content-center">
            <button type="submit" class="waves-effect waves-light btn-large btn-half-fit">Reset</button>
        </div>
    </div>
</form>
<?php require_once __DIR__ . '/layout/foo.php'; ?>