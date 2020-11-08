<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>Register</h1>
                    <hr>
                    <?php var_dump($errors); ?>
                    <form action="<?php echo url("auth.register") ?>" method="POST">
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

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="birthdate">Birthdate</label>
                                <input type="date" name="birthdate" class="form-control <?php echo isset($errors) && !is_null($errors->first("birthdate")) ? "is-invalid" : ""; ?>" id="birthdate" value="<?php echo isset($model) ? $model->get("birthdate") : ""; ?>" aria-describedby="birthdate_error">
                                <div id="birthdate_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("birthdate") : ""; ?></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="phone" name="phone" class="form-control <?php echo isset($errors) && !is_null($errors->first("phone")) ? "is-invalid" : ""; ?>" id="phone" value="<?php echo isset($model) ? $model->get("phone") : ""; ?>" aria-describedby="phone_error">
                                <div id="phone_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("phone") : ""; ?></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="company">Company</label>
                                <input type="text" name="company" class="form-control <?php echo isset($errors) && !is_null($errors->first("company")) ? "is-invalid" : ""; ?>" id="company" value="<?php echo isset($model) ? $model->get("company") : ""; ?>" aria-describedby="company_error">
                                <div id="company_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("company") : ""; ?></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="speciality">Speciality</label>
                                <input type="text" name="speciality" class="form-control <?php echo isset($errors) && !is_null($errors->first("speciality")) ? "is-invalid" : ""; ?>" id="speciality" value="<?php echo isset($model) ? $model->get("speciality") : ""; ?>" aria-describedby="speciality_error">
                                <div id="speciality_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("speciality") : ""; ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" name="gender" class="form-control <?php echo isset($errors) && !is_null($errors->first("gender")) ? "is-invalid" : ""; ?>" id="gender" value="<?php echo isset($model) ? $model->get("gender") : ""; ?>" aria-describedby="gender_error">
                            <div id="gender_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("gender") : ""; ?></div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea row="30" name="notes" class="form-control <?php echo isset($errors) && !is_null($errors->first("notes")) ? "is-invalid" : ""; ?>" id="notes" aria-describedby="notes_error">
                                <?php echo isset($model) ? $model->get("notes") : ""; ?>
                            </textarea>
                            <div id="notes_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("notes") : ""; ?></div>
                        </div>



                        <button type="submit" class="btn btn-primary">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>