<?php $page = isset($_GET['page']) ? $_GET['page'] : ""; ?>

<header>
    <div class="menu d-flex justify-content-between align-items-center">
        <a href="home">
            <div class="logo">
                <img src="./assets/img/system/logo.png" alt="logo" id="imglogo">
            </div>
        </a>
        <div class="menu-right d-flex gap-3 align-items-center">
            <div class="d-flex gap-2">
                <button class="button-primary" onclick="updatePosts()"><span><i class="fa-solid fa-arrows-rotate pt-1"></i></span></button>
                <a href="newpost"><button class="button-primary"><span>Post</span></button></a>
            </div>
            <?php if (isset($_SESSION['status_login_pricture'])) { ?>
                <div class="menu-user">
                    <div class="dropdown dropdown-menu-end">
                        <div class="img-user" data-bs-toggle="dropdown">
                            <img src="./assets/img/<?php echo $_SESSION['userdata']['img_profile'] ? 'user/img-profile/'.$_SESSION['userdata']['img_profile'].'?upd='.time() : "system/defaultprofile.jpg"; ?>" alt="profile">
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
                            <!-- <li><a class="dropdown-item" href="myfriends">
                                <i class="fa-solid fa-users"></i>
                                <span>My friends</span>
                            </a></li> -->
                            <li><a class="dropdown-item" onclick="toggleMode()">
                                <i class="fa-solid fa-circle-half-stroke"></i>
                                Light/Dark
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