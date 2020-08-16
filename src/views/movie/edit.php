<?php require_once __DIR__ . '/../layout/header.php'; ?>

<form action="/movie/edit/<?= $data['id'] ?>" enctype="multipart/form-data" method="POST" autocomplete="off">
    <div class="mx-auto py-8 w-full max-w-4xl">
        <div class="md:grid grid-cols-2 items-center justify-start">
            <div class="mr-16 w-full">
                <div class="mx-auto h-56 w-64 rounded-lg overflow-hidden">
                    <img src="/images/thumbnails/<?= $data['thumbnail'] ?>" alt="<?= $data['name'] ?>" class="h-full">
                </div>
                <label for="movieCover" class="my-5 mx-auto max-w-xs btn btn-neutral">
                    <span>Upload new thumbnail</span>
                    <input type="file" name="thumbnail" id="movieCover" onchange="previewImage(event)" required hidden />
                </label>
            </div>
            <div>
                <input type="number" name="id" value="<?= $data['id'] ?>" hidden>
                <label for="name" class="text-gray-500">Name:</label>
                <input type="text" name="name" id="name" value="<?= $data['name'] ?>" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none" required>
                <label for="genre" class="text-gray-500">Genre:</label>
                <select name="genre" id="genre" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none" required>
                    <option value="<?= $data['genre'] ?>"><?= ucfirst($data['genre']) ?></option>
                    <option value="action">Action</option>
                    <option value="comedy">Comedy</option>
                    <option value="animation">Animation</option>
                    <option value="thriller">Thriller</option>
                    <option value="documentary">Documentary</option>
                </select>
                <label for="price" class="text-gray-500">Price:</label>
                <input type="number" name="price" id="price" value="<?= $data['price'] ?>" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none">
                <label for="description" class="text-gray-500">Description:</label>
                <textarea name="description" id="description" class="my-2 p-2 w-full block bg-gray-800 border-b border-gray-700 rounded focus:outline-none" placeholder="Description" required><?= $data['description'] ?></textarea>
            </div>
        </div>
        <div class="action my-8 grid grid-cols-2 gap-2">
            <button type="button" onclick="if(!confirm('Are you sure you want to delete this movie? This cannot be undone')) return; window.location.href = '/movie/remove/<?= $data['slug'] ?>'" class="btn btn-outline btn-danger w-full">Delete movie</button>
            <button type="submit" class="btn btn-success w-full">Update movie</button>
        </div>
    </div>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>