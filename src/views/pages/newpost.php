<div class="main">

    <div class="white-box">

        <div>
            <h5 class="page-title">New post</h5>

            <div class="create-post">
                <form method="post" class="d-flex flex-column gap-2" id="newPost">
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Category</label>
                        <select class="form-select" name="category" required>
                            <option value="0" selected>None</option>
                            <?php foreach ($categories as $key => $value) { ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="img-post-preview">
                            <img src="./assets/img/system/defaultimg.jpg" alt="img post" id="img-preview">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="img-post" class="form-label">Image</label>
                        <input type="file" class="form-control" id="img-post" name="img" onchange="handleFileImage(this.files, 'img-preview')" required>
                    </div>
                    <div class=" mb-3">
                        <label for="img-post" class="form-label">Text</label>
                        <textarea class="form-control" rows="5" name="text" id="text-post-input"></textarea>
                        <div id="text-post">
                            Look at the image I uploaded!
                        </div>
                    </div>
                    <div><button type="submit" class="button-primary">Submit</button></div>
                </form>
            </div>

        </div>

    </div>

</div>
