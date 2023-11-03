<div class="main">

    <div class="white-box">
        <div class="content-center">
            <div class="content-post d-flex align-items-center flex-column gap-3">

                <div class="d-flex gap-2 align-items-center">
                    <div class="user-post">
                        <a href="user?id=<?php echo $post['id_user']; ?>"><img src="./assets/img/<?php echo $post['img_profile'] ? 'user/img-profile/'.$post['img_profile'] : 'system/defaultprofile.jpg'; ?>" alt="image profile"></a>
                    </div>
                    <span class="user-name"><a href="user?id=1"><?php echo $post['username']; ?></a></span>
                </div>

                <div class="img">
                    <img src="./assets/img/posts/<?php echo $post['img'] ?>" alt="img post" onerror="this.src = './assets/img/system/defaultimg.jpg'" class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#viewimg">
                </div>

                <div class="stats d-flex justify-content-between">
                    <div>
                        <span class="relativedate"><?php echo $post['timestamp_create']; ?></span>
                    </div>
                    <div>
                        <span class="comments">
                            <span id="num_comments"><?php echo $post['num_comments']; ?></span> <i class="fa-solid fa-comment"></i>
                        </span>
                        <span class="hearts">
                            <span id="num_hearts"><?php echo $post['num_hearts']; ?></span> <i class="fa-solid fa-heart cursor-pointer btn-like <?php if ($favorite) {
                                   echo "active";} ?>" onclick="changeFavorite(this,<?php echo $post['id']; ?>)"></i>
                        </span>
                    </div>
                </div>

                <hr>

                <div class="extract">
                    <?php echo $post['extract']; ?>
                </div>

                <hr>

                <div class="comments w-100">
                    <h4 class="mb-5">Comments</h4>
                    <div>

                        <div class="d-flex flex-column gap-4 w-100" id="comments-post">
                            <?php foreach ($comments as $key => $value) { ?>
                            <div class="w-100">

                                <div class="d-flex gap-2">
                                    <div>
                                        <div class="user-post">
                                            <a href="user?id=<?php echo $value['id_user']; ?>"><img src="./assets/img/<?php echo $value['img_profile'] ? 'user/img-profile/'.$value['img_profile'] : 'system/defaultprofile.jpg'; ?>" alt="image profile"></a>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column w-100">
                                        <div class="d-flex justify-content-between">
                                            <span class="user-name">
                                                <a href="user?id=1"><?php echo $value['username']; ?></a> <span class="ms-2 text-secondary relativedate"><?php echo $value['timestamp_create']; ?></span>
                                            </span>
                                            <span>
                                                <?php if (isset($_SESSION['status_login_pricture'])) {
                                                    if ($_SESSION['userdata']['id'] == $value['id_user'] || $_SESSION['userdata']['id_rol'] <= 2) { ?>
                                                    <a class="text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#confirmDeleteComment" onclick="deleteComment(<?php echo $value['id_user'] . ',' . $value['id'] . ',' . $idpost; ?>)"><i class="fa-solid fa-trash"></i></a>
                                                <?php }
                                                } ?>
                                            </span>
                                        </div>
                                        <span class="p-2"><?php echo $value['comment']; ?></span>
                                    </div>
                                </div>

                            </div>
                            <?php } ?>
                        </div>

                        <hr>

                        <div>
                        <?php if(isset($_SESSION['status_login_pricture'])){ ?>
                            <form method="post" id="comment">
                                <div class="mb-3 mt-3">
                                    <input type="hidden" name="id" id="idpost" value="<?php echo $idpost; ?>" required>
                                    <label for="comment">Leave a comment:</label>
                                    <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
                                </div>
                                <button type="submit" class="button-primary">Submit</button>
                            </form>
                            <?php }else{ ?>
                                <i><a href="login">Log in</a> or <a href="signup">Sign up</a> to comment on posts</i>
                            <?php } ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        

    </div>

</div>

<!----------------------------------------->
<!--------------MODALS--------------------->
<!----------------------------------------->
<div class="modal" id="confirmDeleteComment">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">¿Are you sure you want delete?</h4>
        <a type="button" class="button-close" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark"></i>
        </a>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="deleteCommentPost" method="post">
            <input type="hidden" name="id_user" id="delete-idusercomm">
            <input type="hidden" name="id_comm" id="delete-idcomm">
            <input type="hidden" name="idpost" id="delete-idpost">
            <button type="submit" class="button-primary" data-bs-dismiss="modal">Confirm</button>
        </form>
      </div>

    </div>
  </div>
</div>
<!----------------------->
<div class="modal" id="viewimg">
  <div class="modal-dialog modal-big">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <a type="button" class="button-close" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark"></i>
        </a>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="w-100">
            <img src="./assets/img/posts/<?php echo $post['img'] ?>" alt="img post" onerror="this.src = './assets/img/system/defaultimg.jpg'" class="w-100">
        </div>
      </div>

    </div>
  </div>
</div>