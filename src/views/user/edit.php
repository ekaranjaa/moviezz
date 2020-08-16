<?php require_once __DIR__ . '/../layout/header.php'; ?>

<form action="/user/edit/<?= $data['username'] ?>" enctype="multipart/form-data" method="POST" autocomplete="off">
    <div class="mx-auto py-8 w-full max-w-4xl">
        <div class="md:grid grid-cols-2 items-center justify-start">
            <div class="mr-16 w-full">
                <div class="mx-auto h-56 w-56 rounded-full overflow-hidden">
                    <img src="/images/users/<?= $data['avatar'] ?>" alt="<?= $data['name'] ?>" class="h-full">
                </div>
                <label for="profilePhoto" class="my-5 mx-auto max-w-xs btn btn-neutral">
                    <span>Upload new photo</span>
                    <input type="file" name="avatar" id="profilePhoto" onchange="previewImage(event)" required hidden />
                </label>
            </div>
            <div>
                <input type="number" name="id" value="<?= $data['id'] ?>" hidden>
                <label for="name" class="text-gray-500">Name:</label>
                <input type="text" name="name" id="name" value="<?= $data['name'] ?>" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none" required>
                <label for="email" class="text-gray-500">Email:</label>
                <input type="email" name="email" id="email" value="<?= $data['email'] ?>" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none" required>
                <label for="password" class="text-gray-500">Password:</label>
                <p class="my-2 p-2 w-full text-xs text-gray-800 bg-orange-300 rounded">Input current or new password and confirm to continue.</p>
                <input type="password" name="password" id="password" placeholder="Password" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none" required>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" value="<?= $data['confirm_password'] ?>" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none" required>
            </div>
        </div>
        <div class="action my-8 grid grid-cols-2 gap-2">
            <button type="button" onclick="if(!confirm('Are you sure you want to delete your account? This cannot be undone')) return; window.location.href='/user/remove/<?= $data['username'] ?>'" class="btn btn-outline btn-danger w-full">Delete account</button>
            <button type="submit" class="btn btn-success w-full">Update profile</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>