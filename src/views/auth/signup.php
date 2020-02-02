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
        <?php $form_input = !empty($_SESSION['form_input']) ? $_SESSION['form_input'] : ''; ?>
        <form action="/user/signup" method="post" enctype="multipart/form-data">
            <div class="control field">
                <input class="input" type="file" name="avatar">
            </div>
            <div class="control field">
                <input class="input" type="text" name="name" value="<?= $form_input['name'] ?>" placeholder="Name" autofocus>
            </div>
            <div class="control field">
                <input class="input" type="text" name="email" value="<?= $form_input['email'] ?>" placeholder="Email">
            </div>
            <div class="control field">
                <input class="input" type="text" name="username" value="<?= $form_input['username'] ?>" placeholder="Username">
            </div>
            <div class="control field">
                <input class="input" type="password" name="password" placeholder="Password">
            </div>
            <div class="control field">
                <input class="input" type="password" name="confirm_password" placeholder="Confirm password">
            </div>
            <div class="control field">
                <div class="has-text-centered">
                    <button class="button is-info">Submit</button>
                </div>
            </div>
            <div class="control field">
                <p class="is-size-7 has-text-grey-light">Already have a account ? <a href="/user/login" class="has-text-grey-dark">login</a></p>
            </div>
        </form>
        <?php unset($_SESSION['form_input']); ?>
    </div>
</div>
<?php require_once __DIR__ . '/../layout/foo.php'; ?>