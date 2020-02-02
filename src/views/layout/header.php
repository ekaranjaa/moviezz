<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="nav-items">
        <?php $user = !empty($_COOKIE['user']) ? unserialize($_COOKIE['user']) : $_SESSION['user']; ?>
        <?php if (isset($user)) : ?>
            <div class="user-pp circular">
                <a href="/user/edit/<?= $user['username'] ?>" title="<?= $user['name'] ?>">
                    <img src="/images/<?= $user['avatar'] ?>" alt="<?= $user['name'] ?>">
                </a>
            </div>
            &nbsp;
            <h2 class="is-size-5"><?= ucwords($user['username']) ?></h2>
        <?php else : ?>
            <div class="user-pp circular">
                <a class="has-text-grey-dark" href="/">
                    <i class="fas fa-user-circle"></i>
                </a>
            </div>
        <?php endif; ?>

        <div class="nav">
            <button id="back" class="button is-light nav-controll circular"><i class="fas fa-long-arrow-alt-left"></i></button>
            <button id="home" class="button is-light nav-controll circular"><i class="fas fa-home"></i></button>
            <button id="forward" class="button is-light nav-controll circular"><i class="fas fa-long-arrow-alt-right"></i></button>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <?php
                        if (isset($user)) :
                        ?>
                            <a class="button is-light" href="/user/logout">Log out</a>
                        <?php else : ?>
                            <a class="button is-primary" href="/user/signup"><strong>Sign up</strong></a>
                            <a class="button is-light" href="/user/login">Signin</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>