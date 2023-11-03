<div class="main">

    <div class="white-box">
    
        <div id="view-mode">

            <div class="d-flex justify-content-between">
                <h5 class="page-title">User profile <span id="loading"><div class='spinner-border'></div></span></h5>
                <!-- <button class="button-secondary btn-save">Add friend <img src="./assets/img/system/pticket.png" width="15px"></button> -->
            </div>

            <div class="main-profile">

                <div>
                    <div class="img-profile">
                        <?php if (isset($user['img_profile'])) { ?>
                            <img src="./assets/img/user/img-profile/<?php echo $user['img_profile'].'?upd='.time(); ?>" alt="profileimg">
                        <?php } else { ?>
                            <img src="./assets/img/system/defaultprofile.jpg" alt="profileimg">
                        <?php } ?>
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
                            <p id="view-registration"><?php echo date("d-m-Y", strtotime($user['timestamp_create'])); ?> [d/m/Y]</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
</div>