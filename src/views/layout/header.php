<nav class="navbar" role="navigation" aria-label="main navigation">
    <?php if (isset($_SESSION['user'])) : ?>
        <div class="user-pp circular">
            <a href="/user/edit/<?= $_SESSION['user']['id'] ?>" title="<?= $_SESSION['user']['name'] ?>">
                <img src="<?= asset('images', $_SESSION['user']['avatar']) ?>" alt="<?= $_SESSION['user']['name'] ?>">
            </a>
        </div>
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
                    if (isset($_SESSION['user'])) :
                    ?>
                        <a class="button is-light" href="/user/signout">Log out</a>
                    <?php else : ?>
                        <a class="button is-primary" href="/user/register"><strong>Sign up</strong></a>
                        <a class="button is-light" href="/user/signin">Signin</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>