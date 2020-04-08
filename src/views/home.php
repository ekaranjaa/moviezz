<?php require_once __DIR__ . '/layout/head.php'; ?>
<div class="row">
    <?php if (!empty($data)) : ?>
        <?php foreach ($data as $movie) : ?>
            <?php
            $time = explode(' ', $movie['created_at']);
            ?>
            <div class="col s4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="/images/thumbnails/<?= $movie['cover_image'] ?>" alt="<?= $movie['name'] ?>">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4"><?= $movie['name'] ?><i class="material-icons right">more_vert</i></span>
                        <span><?= $time[0] ?></span>
                        <b class="right red-text">Ksh. <?= $movie['price'] ?></b>
                    </div>
                    <?php if ($user) : ?>
                        <div class="card-action sticky-action">
                            <a href="/movie/edit/<?= $movie['id'] ?>" class="waves-effect waves-ripple teal-text"><i class="material-icons">edit</i></a>
                            <a href="/movie/delete/<?= $movie['slug'] ?>" class="waves-effect waves-ripple teal-text"><i class="material-icons">delete</i></a>
                        </div>
                    <?php endif; ?>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4"><?= $movie['name'] ?><i class="material-icons right">close</i></span>
                        <p><b>Time:</b> <?= $time[0] ?></p>
                        <p><b>Type:</b> <?= $movie['type'] ?></p>
                        <p><b>Price:</b> <?= $movie['price'] ?></p>
                        <h6>Description</h6>
                        <div class="divider"></div>
                        <p><?= $movie['description'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <?php if ($user) : ?>
            <h3>Looks like you've not added any movies yet</h3>
        <?php else : ?>
            <h3>No movies available</h3>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/layout/foo.php'; ?>