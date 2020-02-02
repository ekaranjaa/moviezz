<?php
require_once __DIR__ . '/layout/head.php';
require_once __DIR__ . '/layout/header.php';
?>
<div class="content">
    <?php if (isset($_SESSION['fb']) && !empty($_SESSION['fb'])) : ?>
        <div class="notification is-info">
            <strong>
                <?= $_SESSION['fb'];
                unset($_SESSION['fb']); ?>
            </strong>
        </div>
    <?php endif; ?>
    <div class="columns">
        <?php if (isset($user)) : ?>
            <div class="column is-3">
                <?php
                if (!empty($data['id'])) {
                    $action = '/movie/edit/' . $data['id'];
                    $btntext = 'Update';
                } else {
                    $action = '/movie/add';
                    $btntext = 'Add';
                }
                ?>
                <?php $form_input = !empty($_SESSION['form_input']) ? $_SESSION['form_input'] : ''; ?>
                <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= !empty($data['id']) ? $data['id'] : '' ?>">
                    <div class="control field">
                        <input class="input" type="file" name="cover_image" value="<?= !empty($data['image']) ? $data['image'] : '' ?>">
                    </div>
                    <div class="control field">
                        <input class="input" type="text" name="name" value="<?= !empty($data['name']) ? $data['name'] : $form_input['name'] ?>" placeholder="Name" autofocus>
                    </div>
                    <div class="control field">
                        <input class="input" type="text" name="genre" value="<?= !empty($data['genre']) ? $data['genre'] : $form_input['genre'] ?>" placeholder="Genre">
                    </div>
                    <div class="control field">
                        <input class="input" type="number" name="price" value="<?= !empty($data['price']) ? $data['price'] : $form_input['price'] ?>" placeholder="Price">
                    </div>
                    <div class="control field">
                        <div class="has-text-centered">
                            <button class="button is-info"><?= $btntext ?></button>
                        </div>
                    </div>
                </form>
                <?php unset($_SESSION['form_input']); ?>
            </div>
        <?php endif; ?>
        <?php if (!isset($data['id'])) : ?>
            <div class="column">
                <table class="table is-bordered is-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Genre</th>
                            <th>Price</th>
                            <th>Date produced</th>
                            <th>Controlls</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $movie) : ?>
                            <tr>
                                <td><?= $movie['name'] ?></td>
                                <td><?= $movie['genre'] ?></td>
                                <td><?= $movie['price'] ?></td>
                                <td><?= $movie['created_at'] ?></td>
                                <td>
                                    <?php if (isset($user)) : ?>
                                        <a class="button is-info is-small" href="/movie/edit/<?= $movie['id'] ?>"><i class="far fa-edit"></i></a>
                                        <a class="button is-danger is-small" href="/movie/delete/<?= $movie['id'] ?>"><i class="far fa-trash-alt"></i></a>
                                    <?php endif; ?>
                                    <a class="button is-warning is-small" href="/movie/display/<?= $movie['id'] ?>"><i class="far fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
require_once __DIR__ . '/layout/footer.php';
require_once __DIR__ . '/layout/foo.php';
?>