<?php $page = isset($_GET['page']) ? $_GET['page'] : ""; ?>

<header>
    <div class="menu d-flex justify-content-between align-items-center">
        <div class="logo">
            <img src="./assets/img/system/logo.png" alt="logo">
        </div>
        <div class="menu-right d-flex gap-3 align-items-center">
            <div>
                <button class="button-primary"><span><i class="fa-solid fa-arrows-rotate pt-1"></i></span></button>
                <button class="button-primary"><span>Post</span></button>
            </div>
            <?php if (isset($_SESSION['status_login_pricture'])) { ?>
                <div class="menu-user">
                    <div class="dropdown dropdown-menu-end">
                        <div class="img-user" data-bs-toggle="dropdown">
                            <img src="./assets/img/system/defaultprofile.jpg" alt="logo">
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="myprofile">
                                <i class="fa-solid fa-user"></i>
                                <span>My profile</span>
                            </a></li>
                            <li><a class="dropdown-item" href="myposts">
                                <i class="fa-solid fa-file-lines"></i>
                                <span>My posts</span>
                            </a></li>
                            <li><a class="dropdown-item" href="myfriends">
                                <i class="fa-solid fa-users"></i>
                                <span>My friends</span>
                            </a></li>
                            <!-- <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-gear"></i>
                                <span>Settings</span>
                            </a></li> -->
                            <li><hr class="dropdown-divider"></hr></li>
                            <li><a class="dropdown-item" href="logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Log out</span>
                            </a></li>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div>
                    <a href="login"><button class="button-display"><span>Login</span></button></a>
                </div>
            <?php } ?>
        </div>
    </div>
</header>