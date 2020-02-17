<nav class="navbar-fixed">
    <nav class="nav-extended">
        <div class="nav-wrapper s-container">
            <a class="brand-logo" href="/">Moviezzz</a>
            <ul class="right hide-on-med-and-down">
                <?php if (!$user) : ?>
                    <li><a class="waves-effect waves-light btn modal-trigger" href="#login">Login</a></li>
                <?php else : ?>
                    <li class="dropdown-trigger">
                        <a class="user-profile dropdown-trigger">
                            <div class="profile-image">
                                <img src="/images/<?= $user['avatar'] ?>" alt="<?= $user['name'] ?>">
                            </div>
                            <span><?= $user['username'] ?></span>
                        </a>
                        <ul class="dropdown-content">
                            <li><a href="/user/profile/<?= $user['slug'] ?>">Profile</a></li>
                            <li><a href="/user/logout<?= $user['slug'] ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="nav-wrapper s-container">
            <div class="col s12">
                <a href="/" class="breadcrumb">Home</a>
                <?php if ($user) : ?>
                    <a href="#addMovie" class="btn-floating btn-large halfway-fab waves-effect waves-light teal modal-trigger">
                        <i class="material-icons">add</i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</nav>

<!-- Login / Signup modal -->
<div id="login" class="modal">
    <div class="modal-content">
        <a class="modal-close waves-effect waves-light btn-flat right"><i class="material-icons">close</i></a>
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s6"><a href="#login" class="active">Loign</a></li>
                    <li class="tab col s6"><a href="#signup">Signup</a></li>
                </ul>
            </div>
            <div id="login" class="col s12">
                <div class="container-half">
                    <form action="/user/login" method="POST">
                        <div class="input-field">
                            <input id="loginUsername" type="text" name="username" class="validate" value="<?= $return_data['username'] ?>">
                            <label for="loginUsername">Username</label>
                        </div>
                        <div class="input-field">
                            <input id="loginPassword" type="password" name="password" class="validate">
                            <label for="loginPassword">Password</label>
                        </div>
                        <p class="right-align">
                            <span><a href="/user/reset" class="materialize-red-text">Forgot password ?</a></span>
                        </p>
                        <p>
                            <label>
                                <input type="checkbox" value="1" name="remember_me" checked />
                                <span>Remember me</span>
                            </label>
                        </p>
                        <div class="content-center">
                            <button type="submit" class="waves-effect waves-light btn-large btn-half-fit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="signup" class="col s12">
                <form action="/user/signup" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="name" type="text" name="name" class="validate" value="<?= $return_data['name'] ?>">
                            <label class="active" for="name">Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="email" type="text" name="email" class="validate" value="<?= $return_data['email'] ?>">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="username" type="text" name="username" class="validate" value="<?= $return_data['username'] ?>">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="password" type="password" name="password" class="validate">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="confirmPassword" type="password" name="confirm_password" class="validate">
                            <label for="confirmPassword">Confirm password</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>File</span>
                                <input type="file" name="avatar">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Choose image">
                            </div>
                        </div>
                    </div>
                    <div class="content-center">
                        <button type="submit" class="waves-effect waves-light btn-large btn-half-fit">Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Movie modal -->
<div id="addMovie" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Add movie</h4>
            <a class="modal-close waves-effect waves-light btn-flat"><i class="material-icons">close</i></a>
        </div>
        <form action="/movie/add" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="file-field input-field col s12">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" name="cover_image">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Choose cover image">
                    </div>
                </div>
                <div class="input-field col s6">
                    <input id="loginName" type="text" name="name" class="validate" value="<?= $return_data['name'] ?>">
                    <label class="active" for="loginName">Name</label>
                </div>
                <div class="input-field col s6">
                    <input id="price" type="text" name="price" class="validate" value="<?= $return_data['price'] ?>">
                    <label class="active" for="price">Price</label>
                </div>
                <div class="input-field col s12">
                    <select name="type">
                        <option value="" disabled selected>Choose option</option>
                        <option value="Action">Action</option>
                        <option value="Thriller">Thriller</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Series">Series</option>
                        <option value="Animation">Animation</option>
                        <option value="Documentary">Documentary</option>
                    </select>
                    <label>Type</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="description" class="materialize-textarea" name="description"><?= $return_data['description'] ?></textarea>
                    <label for="description">Ddescription</label>
                </div>
            </div>
            <div class="content-center">
                <button type="submit" class="waves-effect waves-light btn-large btn-half-fit">Add</button>
            </div>
        </form>
    </div>
</div>

<?php unset($_SESSION['form_input']); ?>