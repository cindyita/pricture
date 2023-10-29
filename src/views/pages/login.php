<div class="main-login">

    <div class="login pink-box">
        <div class="logo">
            <img src="./assets/img/system/logo.png" alt="logo">
        </div>
        <div>
            <h4>Login</h4>
            <form method="post" id="login">
                <div class="alert alert-danger" id="error-login">
                    <strong>Alert:</strong> <span>Error in login</span>
                </div>
                <div class="mb-3 mt-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass">
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember"> Remember me
                    </label>
                </div>
                <div class="txt-secondary py-2 pb-4 d-flex flex-column">
                    <!-- <a href=""><span>I forgot the password</span></a> -->
                    <a href="signup"><span>I don't have an account</span></a>
                </div>
                <button type="submit" class="button-primary">Login</button>
            </form>
        </div>
    </div>

</div>