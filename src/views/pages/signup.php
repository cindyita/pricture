<div class="main-login">

    <div class="login pink-box">
        <div class="logo">
            <img src="./assets/img/system/logo.png" alt="logo">
        </div>
        <div>
            <h4>Sign up</h4>
            <form method="post" id="signup">
                <div class="alert alert-danger" id="error-login">
                    <strong>Alert:</strong> <span>That username already exists</span>
                </div>
                <div class="alert alert-success" id="success-login">
                    <strong>¡Success!</strong> <span>You have successfully registered. You can now log in</span>
                </div>
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" onblur="checkExist(this,'email')" required>
                </div>
                <div class="mb-3 mt-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" onblur="checkExist(this,'username')" required>
                </div>
                <div class="mb-3">
                    <label for="pwd" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass" onblur="checkpass()" required>
                </div>
                <div class="mb-3">
                    <label for="cpwd" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="cpass" placeholder="Enter password" name="cpass" onblur="confirmpass()" required>
                </div>
                <div class="txt-secondary py-2 pb-4 d-flex flex-column">
                    <a href="login"><span>I already have an account</span></a>
                </div>
                <button type="submit" class="button-primary">Sign up</button>
            </form>
        </div>
    </div>

</div>