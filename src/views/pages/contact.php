<div class="main">

    <div class="white-box">
        <div class="d-flex justify-content-center">
            <h5 class="page-title">Contact us</h5>
        </div>
        <div class="d-flex justify-content-center">

            <form method="post" id="contact" class="contact-form">
                <div class="mb-3 mt-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                </div>
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                </div>
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Subject:</label>
                    <select class="form-select" name="subject">
                        <option>Suggestion</option>
                        <option>Bug report</option>
                        <option>Problem</option>
                        <option>Contact</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Comment:</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" placeholder="enter your suggestions or bug report"></textarea>
                </div>
                <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE; ?>"></div>
                <div><button type="submit" class="button-primary mt-2">Submit</button></div>
            </form>

        </div>
    </div>
</div>
