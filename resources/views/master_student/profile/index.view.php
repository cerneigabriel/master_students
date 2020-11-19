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