<div class="main">

    <div class="white-box">
        <div class="d-flex justify-content-between">
            <h5 class="page-title">My posts</h5>
        </div>

        <div class="d-flex flex-column gap-3 w-100 mt-4" id="myposts">

            <?php foreach ($posts as $key => $value) { ?>
            <div class="green-card">
                <div class="head">
                    <div class="img">
                        <img src="./assets/img/posts/<?php echo $value['img'] ?>" alt="img post" onerror="this.src = './assets/img/system/defaultimg.jpg'">
                    </div>
                    <div class="info">
                        <strong>Post id: <?php echo $value['id']; ?></strong>
                        <span>Category: <?php echo $value['category']; ?></span>
                        <span class="dateFormat">Created: <?php echo $value['timestamp_create']; ?></span>
                    </div>
                </div>
                <div class="options">
                    <div class="dropdown">
                        <a class="btn button-options" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" onclick="deletePost(<?php echo $value['id']; ?>)">Delete post <i class="fa-solid fa-trash"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } ?>
            
        </div>

        <?php if(!$posts){
            echo "<i><span class='text-secondary'>You haven't published anything yet</span></i>";
        } ?>

    </div>

</div>