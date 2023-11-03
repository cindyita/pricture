<div class="main">

    <div class="white-box">

        <div class="posts d-flex gap-5 flex-wrap justify-content-start flex-column flex-lg-row" id="home-posts">
        
            <?php foreach ($post as $key => $value) { ?>
            <div class="post-pink-box post d-flex flex-column gap-2">

                <div  class="d-flex w-100 justify-content-between align-items-center flex-column flex-sm-row">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="user-post">
                            <img src="./assets/img/<?php echo $value['img_profile'] ? 'user/img-profile/'.$value['img_profile'] : 'system/defaultprofile.jpg'; ?>" alt="image profile">
                        </div>
                        <span class="user-name"><a href="user?id=1"><?php echo $value['username']; ?></a></span>
                    </div>
                    <div class="stats">
                        <a href="post?id=<?php echo $value['id']; ?>">
                            <span class="comments">
                                <?php echo $value['num_comments']; ?> <i class="fa-solid fa-comment"></i>
                            </span>
                        </a>
                        <span class="hearts">
                            <span class="numHearts"><?php echo $value['num_hearts']; ?></span> <i class="fa-solid fa-heart btn-like <?php if (in_array($value['id'],$favorites)) {
                                    echo "active";
                                } ?>" onclick="changeFavorite(this,<?php echo $value['id']; ?>)"></i>
                        </span>
                    </div>                
                </div>

                <div>
                    <a href="post?id=<?php echo $value['id']; ?>">
                        <div class="img-post">
                            <img src="./assets/img/<?php echo $value['img'] ? 'posts/'.$value['img'] : 'system/defaultimg.jpg'; ?>" alt="image">
                        </div>
                    </a>
                </div>

                <div class="d-flex justify-content-between options">
                    <span class="date relativedate"><?php echo $value['timestamp_create']; ?></span>
                    <span class="d-flex gap-2 d-none">
                        <a onclick="viewCollection()"><i class="fa-solid fa-images"></i></a>
                        <a onclick="addBookmark()"><i class="fa-solid fa-bookmark"></i></a>
                    </span>
                </div>
                <div>
                    <a href="post?id=<?php echo $value['id']; ?>"><span class="extract"><?php echo reducirTexto($value['extract'], 110); ?></span></a>
                </div>

            </div>
            <?php } ?>

        </div>

    </div>
    
</div>
