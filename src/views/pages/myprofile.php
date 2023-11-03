<div class="main">

    <div class="white-box">
    
        <div id="view-mode">

            <div class="d-flex justify-content-between">
                <h5 class="page-title">My profile <span id="loading"><div class='spinner-border'></div></span></h5>
                <button class="button-secondary btn-save" onclick="changeMode('edit')">Edit <i class="fa-solid fa-pen-to-square"></i></button>
            </div>

            <div class="main-profile">

                <div>
                    <div class="img-profile">
                        <img src="./assets/img/<?php echo isset($user['img_profile']) ? 'user/img-profile/'.$user['img_profile'].'?upd='.time() : "system/defaultprofile.jpg"; ?>" alt="profileimg">
                    </div>
                    <br>
                    <div class="ribon" id="view-username">
                        <?php echo $user['username']; ?>
                    </div>
                </div>

                <div class="main-profile-info">
                    <div class="info d-flex flex-column gap-3">
                        <div>
                            <strong>Friend Code</strong>
                            <p id="view-friendcode"><?php echo $user['friendcode']; ?></p>
                        </div>
                        <div>
                            <strong>Birthday</strong>
                            <p id="view-birthday"><?php echo $user['birthday']; ?></p>
                        </div>
                        <div>
                            <strong>Idol type</strong>
                            <?php if(isset($custom_brand)){ ?>
                                <p id="view-idol_type" style="color:<?php echo $custom_brand[0]['type_color']; ?>;"><?php echo $custom_brand[0]['type_name']; ?></p>
                            <?php }else{ ?>
                                <p id="view-idol_type" style="color:<?php echo $user['color_idol_type']; ?>;"><?php echo $user['idol_type']; ?></p>
                            <?php } ?>
                        </div>
                        <div>
                            <strong>Favorite brand</strong>
                            <div>
                                <?php if(isset($custom_brand)){ ?>
                                    <span class="text-secondary" id="view_custom_brand_name">[<?php echo $custom_brand[0]['name']; ?>]</span><br>
                                    <img src="./assets/img/user/custom-brands/<?php echo $custom_brand[0]['img'].'?upd='.time(); ?>" width="100px" alt="brand" onerror="this.src = './assets/img/system/brands/1.webp'" id="view-favorite-brand">
                                <?php }else{ ?>
                                    <img src="./assets/img/system/brands/<?php echo $user['id_favorite_brand']; ?>.webp" width="100px" alt="brand" onerror="this.src = './assets/img/system/brands/1.webp'" id="view-favorite-brand">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="biography">
                        <div>
                            <strong>Biography</strong>
                            <p id="view-biography"><?php echo $user['biography']; ?></p>
                        </div>
                        <div>
                            <strong>Registration</strong>
                            <p id="view-registration"><span class="dateFormat"><?php echo $user['timestamp_create']; ?></span> [D/M/Y]</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div id="edit-mode">
            <form method="post" id="saveProfile" enctype="multipart/form-data">

                <div class="d-flex justify-content-between">
                    <h5 class="page-title">Edit my profile</h5>
                    <div>
                        <a class="button-secondary" onclick="changeMode('view')"><i class="fa-solid fa-arrow-left"></i> Return</a>
                        <button class="button-primary btn-save" type="submit" onclick="changeMode('view')" id="saveTop">Save <i class="fa-solid fa-floppy-disk"></i></button>
                    </div>
                </div>

                <div class="main-profile">

                    <div>
                        <div class="img-profile">
                            <img src="./assets/img/<?php echo $user['img_profile'] ? 'user/img-profile/'.$user['img_profile'].'?upd='.time() : "system/defaultprofile.jpg"; ?>" alt="profileimg" id="img-preview">
                        </div>
                        Profile image:
                        <input type="file" name="img-profile" id="img-profile" class="form-control" onchange="handleFileImage(this.files, 'img-preview')">
                        <br>
                        <div class="ribon"> 
                            <input type="hidden" name="actual_username" id="actual_username" value="<?php echo $user['username']; ?>">   
                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $user['username']; ?>" onblur="checkExist('username','username','<?php echo $user['username']; ?>')">
                        </div>
                    </div>

                    <div class="main-profile-info">
                        <div class="info d-flex flex-column gap-3">
                            <div>
                                <strong>Friend Code</strong>
                                <p><input type="text" class="form-control" name="friendcode" id="friendcode" value="<?php echo $user['friendcode']; ?>"></p>
                            </div>
                            <div>
                                <strong>Birthday</strong>
                                <p><input class="form-control" type="date" name="birthday" id="birthday" value="<?php echo $user['birthday']; ?>"></p>
                            </div>
                            <div>
                                <strong>Idol type</strong>
                                <span id="idol_type_preview"><p style="color:<?php echo $user['color_idol_type']; ?>"><?php echo $user['idol_type']; ?></p></span>
                                <select name="custom_type_idol" id="custom_type_idol" class="form-select">
                                    <?php foreach ($type_brands as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if (isset($custom_brand) && $custom_brand[0]['id_type_idol'] == $value['id']) {
                                               echo "selected";} ?>><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div>
                                <strong>Favorite brand</strong>
                                <div>
                                
                                <input type="hidden" name="id_custom_brand" id="id_custom_brand" value="<?php echo isset($custom_brand[0]['id']) ? $custom_brand[0]['id'] : ""; ?>">
                                <input type="hidden" name="id_custom_type" id="id_custom_type" value="<?php echo isset($custom_brand) ? $custom_brand[0]['id_type_idol'] : ""; ?>">

                                    <?php if(isset($custom_brand)){ ?>
                                        <img class="mb-2" src="./assets/img/user/custom-brands/<?php echo $custom_brand[0]['img'].'?upd='.time(); ?>" width="100px" alt="brand" id="favorite_brand_preview" onerror="this.src = './assets/img/system/brands/1.webp'">
                                    <?php }else{ ?>
                                        <img class="mb-2" src="./assets/img/system/brands/<?php echo $user['id_favorite_brand']; ?>.webp" width="100px" alt="brand" id="favorite_brand_preview" onerror="this.src = './assets/img/system/brands/1.webp'">
                                    <?php } ?>

                                    <input type="text" name="name_custom_brand" id="name_custom_brand" class="form-control" placeholder="Name of brand" value="<?php echo isset($custom_brand) ? $custom_brand[0]['name'] : ""; ?>">
                                    <input type="file" name="custom_brand" id="custom_brand" class="form-control my-2" onchange="handleFileSelect(this.files,'favorite_brand_preview')">
                                    <select name="id_favorite_brand" id="id_favorite_brand" class="form-select" onchange="changeBrandPreview()">
                                        <?php foreach ($favorite_brands as $key => $value) { ?>
                                            <option data-type="<?php echo $value['type_name'];?>" data-typecolor="<?php echo $value['type_color'];?>" value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $user['id_favorite_brand']) { echo "selected";} ?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="biography">
                            <div>
                                <strong>Biography</strong>
                                <p><textarea class="form-control" name="biography" id="biography" cols="30" rows="10"><?php echo $user['biography']; ?></textarea></p>
                            </div>
                        </div>
                    </div>

                </div>
                
            </form>
        </div>
        

    </div>
    
</div>