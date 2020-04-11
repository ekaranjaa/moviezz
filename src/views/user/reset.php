<?php require_once __DIR__ . '/../layout/head.php'; ?>
<div class="create p-5">
    <div class="highlight text-center leading-10">
        <h1 class="font-medium text-3xl">Oops! That's not</h1>
        <p class="font-light">How inconvenient of you.</p>
    </div>
    <form action="/user/reset" method="POST" autocomplete="off" class="form">
        <input type="email" name="email" placeholder="Email" value="<?= $return_data['email'] ?>" class="input my-5 mx-auto w-full" required />
        <input type="password" name="password" placeholder="Password" class="input my-5 mx-auto w-full" required />
        <input type="password" name="confirm_password" placeholder="Confirm password" class="input my-5 mx-auto w-full">
        <button type="submit" class="btn btn-primary w-full mx-auto mt-10">RESET PASSWORD</button>
    </form>
</div>
<?php unset($_SESSION['form_input']); ?>
<?php require_once __DIR__ . '/../layout/foo.php'; ?>