<?php

use MasterStudents\Core\Session;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h1>Login</h1>
                    <hr>
                    <form action="<?php echo url("auth.login") ?>" method="POST">
                        <input type="hidden" name="_token" value="<?php echo Session::get("_token") ?>">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control <?php echo isset($errors) && !is_null($errors->first("email")) ? "is-invalid" : ""; ?>" id="email" value="<?php echo isset($model) ? $model->get("email") : ""; ?>" aria-describedby="email_error">
                            <div id="email_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("email") : ""; ?></div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control <?php echo isset($errors) && !is_null($errors->first("password")) ? "is-invalid" : ""; ?>" id="password" aria-describedby="password_error">
                            <div id="password_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("password") : ""; ?></div>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="remember_me" class="form-check-input" id="remember_me" value="true">
                            <label class="form-check-label" for="remember_me">Remember Me</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>