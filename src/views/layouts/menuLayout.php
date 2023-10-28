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
            <div class="menu-user">
                <div class="img-user">
                    <img src="./assets/img/system/defaultprofile.jpg" alt="logo">
                </div>
            </div>
        </div>
    </div>
</header>