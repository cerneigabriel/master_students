<?php

use MasterStudents\Core\Session;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>Register</h1>
                    <hr>
                    <form action="<?php echo url("auth.register") ?>" method="POST">
                        <input type="hidden" name="_token" value="<?php echo Session::get("_token") ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control <?php echo isset($errors) && !is_null($errors->first("first_name")) ? "is-invalid" : ""; ?>" id="first_name" value="<?php echo isset($model) ? $model->get("first_name") : ""; ?>" aria-describedby="first_name_error">
                                <div id="first_name_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("first_name") : ""; ?></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control <?php echo isset($errors) && !is_null($errors->first("last_name")) ? "is-invalid" : ""; ?>" id="last_name" value="<?php echo isset($model) ? $model->get("last_name") : ""; ?>" aria-describedby="last_name_error">
                                <div id="last_name_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("last_name") : ""; ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="first_name">Username</label>
                            <input type="text" name="username" class="form-control <?php echo isset($errors) && !is_null($errors->first("username")) ? "is-invalid" : ""; ?>" id="username" value="<?php echo isset($model) ? $model->get("username") : ""; ?>" aria-describedby="username_error">
                            <div id="username_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("username") : ""; ?></div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control <?php echo isset($errors) && !is_null($errors->first("email")) ? "is-invalid" : ""; ?>" id="email" value="<?php echo isset($model) ? $model->get("email") : ""; ?>" aria-describedby="email_error">
                            <div id="email_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("email") : ""; ?></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control <?php echo isset($errors) && !is_null($errors->first("password")) ? "is-invalid" : ""; ?>" id="password" aria-describedby="password_error">
                                <div id="password_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("password") : ""; ?></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="password_confirm">Confirm Password</label>
                                <input type="password" name="password_confirm" class="form-control <?php echo isset($errors) && !is_null($errors->first("password_confirm")) ? "is-invalid" : ""; ?>" id="password_confirm" aria-describedby="password_confirm_error">
                                <div id="password_confirm_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("password_confirm") : ""; ?></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo assets("assets/js/auth/register.js"); ?>"></script>