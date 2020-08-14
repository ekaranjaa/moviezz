<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="create p-5">
  <div class="highlight text-center leading-10">
    <h1 class="font-medium text-3xl">Welcome back</h1>
    <p class="font-light">See what you're missing out on ;)</p>
  </div>
  <form action="/user/login" method="POST" autocomplete="off" class="mx-auto p-8 max-w-xl" class="form">
    <input type="text" name="username" value="<?= $return_data['username'] ?>" placeholder="Username" class="input my-5" required autofocus />
    <input type="password" name="password" placeholder="Password" class="input my-3 mx-auto w-full" required />
    <p class="text-sm text-right font-light text-indigo-300 mt-3 mb-5">
      Forgot password?
      <a href="/user/reset">reset</a>
    </p>
    <label class="my-5">
      <input type="checkbox" value="1" name="remember_me" checked />
      <span>Remember me</span>
    </label>
    <button type="submit" class="btn btn-primary w-full mx-auto mt-10">LOGIN</button>
    <div class="my-8 flex items-center justify-center">
      <p class="text-sm text-gray-500">Don't have an account?</p>
      <a href="/user/register" class="btn btn-sm btn-text mx-3">CREATE ACCOUNT</a>
    </div>
  </form>
</div>
<?php unset($_SESSION['form_input']); ?>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>