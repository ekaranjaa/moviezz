<?php require_once __DIR__ . '/../layout/head.php'; ?>
<div class="-my-3 -mx-3 md:mx-auto p-5 md:bg-gray-800 max-w-4xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold"><?= $data['name'] ?></h1>
            <a href="/movie/genre/<?= $data['genre'] ?>" class="p-1 text-xs bg-gray-700 rounded"><?= ucfirst($data['genre']) ?></a>
            <?php
            $date = explode(' ', $data['created_at']);
            $date = date_create($date[0]);
            $date = date_format($date, 'd M Y');
            ?>
            <p class="my-3"><?= $date ?></p>
        </div>
        <?php if ($user) : ?>
            <div class="text-gray-500 flex items-center justify-start self-start">
                <a href="/movie/remove/<?= $data['slug'] ?>" class="block mr-3 h-10 w-10 text-center leading-10 rounded-full hover:bg-gray-700"><i class="fas fa-trash-alt"></i></a>
                <a href="/movie/edit/<?= $data['id'] ?>" class="block h-10 w-10 text-center leading-10 rounded-full hover:bg-gray-700"><i class="fas fa-edit"></i></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="w-full h-64 md:h-px-400 rounded-lg overflow-hidden">
        <img src="/images/thumbnails/<?= $data['thumbnail'] ?>" alt="<?= $data['name'] ?>" class="h-full">
    </div>
    <div class="py-5">
        <p><?= $data['description'] ?></p>
    </div>
</div>
<?php require_once __DIR__ . '/../layout/foo.php'; ?>