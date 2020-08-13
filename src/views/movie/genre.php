<?php require_once __DIR__ . '/../layout/head.php'; ?>
<?php if (!empty($data)) : ?>
    <div class="md:flex items-center justify-evenly flex-wrap">
        <?php foreach ($data as $movie) : ?>
            <?php
            $time = explode(' ', $movie['created_at']);
            ?>
            <div class="card mx-auto my-5 md:m-3 p-3 max-w-xs w-full bg-gray-800 rounded hover:shadow-xl transition duration-150 ease-in-out overflow-hidden">
                <div class="head h-48 w-full rounded overflow-hidden">
                    <a href="/movie/display/<?= $movie['slug'] ?>">
                        <img loading="lazy" src="/images/thumbnails/<?= $movie['thumbnail'] ?>" alt="<?= $movie['name'] ?>" class="h-full" />
                    </a>
                </div>
                <div class="body p-2">
                    <a href="/movie/genre/<?= $movie['genre'] ?>" class="p-brand text-xs text-gray-600"><?= ucfirst($movie['genre']) ?></a>
                    <hr class="my-1" />
                    <div class="flex items-center justify-between">
                        <div>
                            <a href="/movie/display/<?= $movie['slug'] ?>" class="p-name block text-xl font-medium truncate"><?= $movie['name'] ?></a>
                            <p class="price mt-2 text-red-300 text-sm">Ksh. <?= $movie['price'] ?></p>
                        </div>
                        <?php if ($user) : ?>
                            <div class="text-gray-500 text-sm flex items-center justify-start self-end">
                                <a href="/movie/remove/<?= $movie['slug'] ?>" class="block mr-3 h-8 w-8 text-center leading-8 rounded-full hover:bg-gray-700"><i class="fas fa-trash-alt"></i></a>
                                <a href="/movie/edit/<?= $movie['id'] ?>" class="block h-8 w-8 text-center leading-8 rounded-full hover:bg-gray-700"><i class="fas fa-edit"></i></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <h3 class="font-semibold text-3xl text-gray-700">No movies available for the specified genre.</h3>
<?php endif; ?>
<?php require_once __DIR__ . '/../layout/foo.php'; ?>