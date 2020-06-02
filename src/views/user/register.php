<?php require_once __DIR__ . '/../layout/head.php'; ?>
<div class="create p-5">
  <div class="highlight text-center leading-10">
    <h1 class="font-medium text-3xl">Join Moviezz</h1>
    <p class="font-light">The best online movie platform.</p>
  </div>
  <form action="/user/register" enctype="multipart/form-data" method="POST" autocomplete="off" class="form">
    <label for="profilePhoto" class="my-5 btn btn-neutral">
      <span>Upload profile photo</span>
      <input type="file" name="avatar" id="profilePhoto" required hidden />
    </label>
    <input type="text" name="name" placeholder="Name" value="<?= $return_data['name'] ?>" class="input my-5 mx-auto w-full" required autofocus />
    <input type="email" name="email" placeholder="Email" value="<?= $return_data['email'] ?>" class="input my-5 mx-auto w-full" required />
    <input type="text" name="username" placeholder="Username" value="<?= $return_data['username'] ?>" class="input my-5 mx-auto w-fullrequired">
    <input type="password" name="password" placeholder="Password" class="input my-5 mx-auto w-full" required />
    <input type="password" name="confirm_password" placeholder="Confirm password" class="input my-5 mx-auto w-full">
    <button type="submit" class="btn btn-primary w-full mx-auto mt-10">CREATE ACCOUNT</button>
    <div class="my-8 flex items-center justify-center">
      <p class="text-sm text-gray-500">Already have an account?</p>
      <a href="/user/login" class="btn btn-sm btn-text mx-3">LOGIN</a>
    </div>
  </form>
</div>
<?php unset($_SESSION['form_input']); ?>
<?php require_once __DIR__ . '/../layout/foo.php'; ?>