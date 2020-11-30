<?php

use MasterStudents\Core\Session;
use MasterStudents\Models\User;

$user = User::find($model->get("id"));
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit #<?php echo $model->get("id") ?></h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url("admin.users.index"); ?>">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</div>

<!-- Row -->
<form class="row align-items-stretch" action="<?php echo url("admin.users.update", ["id" => $model->get("id")]) ?>" method="POST">
  <?php echo csrf_input() ?>

  <!-- Basic information -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Basic information</h6>
      </div>
      <div class="card-body">
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
      </div>
    </div>
  </div>

  <!-- Personal information -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
      </div>
      <div class="card-body">
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
          <select name="gender" class="form-control <?php echo isset($errors) && !is_null($errors->first("gender")) ? "is-invalid" : ""; ?>" id="gender" value="<?php echo isset($model) ? $model->get("gender") : ""; ?>" aria-describedby="gender_error">
            <option value="">Empty</option>
            <option value="m">Male</option>
            <option value="f">Female</option>
          </select>
          <div id="gender_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("gender") : ""; ?></div>
        </div>

        <div class="form-group">
          <label for="notes">Notes</label>
          <textarea row="30" name="notes" class="form-control <?php echo isset($errors) && !is_null($errors->first("notes")) ? "is-invalid" : ""; ?>" id="notes" aria-describedby="notes_error"><?php echo isset($model) ? $model->get("notes") : ""; ?></textarea>
          <div id="notes_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("notes") : ""; ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 pb-4">
    <div class="card h-100">
      <div class="card-body">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</form>

<!-- Row -->
<div class="row align-items-stretch">
  <!-- Change Password -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
      </div>
      <div class="card-body">
        <form action="<?php echo url("admin.users.change_password", ["id" => $model->get("id")]) ?>" method="POST">
          <div class="modal-body">
            <?php echo csrf_input() ?>

            <div class="form-group">
              <label for="old_password">Old Password</label>
              <input type="password" name="old_password" class="form-control <?php echo isset($errors) && !is_null($errors->first("old_password")) ? "is-invalid" : ""; ?>" id="old_password" aria-describedby="old_password_error">
              <div id="old_password_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("old_password") : ""; ?></div>
            </div>

            <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" name="password" class="form-control <?php echo isset($errors) && !is_null($errors->first("password")) ? "is-invalid" : ""; ?>" id="password" aria-describedby="password_error">
              <div id="password_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("password") : ""; ?></div>
            </div>

            <div class="form-group">
              <label for="password_confirm">Confirm New Password</label>
              <input type="password" name="password_confirm" class="form-control <?php echo isset($errors) && !is_null($errors->first("password_confirm")) ? "is-invalid" : ""; ?>" id="password_confirm" aria-describedby="password_confirm_error">
              <div id="password_confirm_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("password_confirm") : ""; ?></div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Security -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Security</h6>
      </div>
      <div class="card-body">
        <div class="row align-items-stretch">
          <div class="col-lg-12">
            <form action="<?php echo url("admin.users.update_roles", ["user_id" => $model->get("id")]) ?>" method="POST">
              <?php echo csrf_input() ?>
              <div class="form-group">
                <label for="roles">Roles</label>
                <select class="form-control d-block" name="roles[]" multiple="multiple" id="roles_input">
                  <?php foreach ($roles as $role) : ?>
                    <option value="<?php echo $role->id ?>" <?php echo $user->hasRole($role) ? "selected" : "" ?>><?php echo $role->name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Attach</button>
              </div>
            </form>
          </div>
          <div class="col-lg-12">
            <form action="<?php echo url("admin.users.update_permissions", ["user_id" => $model->get("id")]) ?>" method="POST">
              <?php echo csrf_input() ?>

              <div class="form-group">
                <label for="permissions">Permissions</label>
                <select class="form-control d-block" name="permissions[]" multiple="multiple" id="permissions_input">
                  <?php foreach ($permissions as $permission) : ?>
                    <option value="<?php echo $permission->id ?>" <?php echo $user->hasPermission($permission) ? "selected" : "" ?>><?php echo $permission->name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Attach</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sessions -->
  <div class="col-lg-12 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Sessions</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover">
            <thead class="thead-light">
              <tr>
                <th>Id</th>
                <th>Active</th>
                <th>Remembered</th>
                <th>Ip</th>
                <th>Created At</th>
                <th>Updated At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($model->get("sessions") as $session) : ?>
                <tr>
                  <td><?php echo $session->id ?></td>
                  <td><?php echo $session->active ? "Yes" : "No" ?></td>
                  <td><?php echo $session->remember_token ? "Yes" : "No" ?></td>
                  <td><?php echo $session->ip ?></td>
                  <td><?php echo $session->created_at ?></td>
                  <td><?php echo $session->updated_at ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Row-->

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to logout?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
        <a href="login.html" class="btn btn-primary">Logout</a>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#roles_input').select2();
    $('#permissions_input').select2();
  });
</script>

<style>
  .select2 {
    display: block;
  }
</style>