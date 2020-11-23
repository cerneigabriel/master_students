<?php

use MasterStudents\Core\Session;

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Create Role</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url("admin.roles.index"); ?>">Roles</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
  </ol>
</div>

<!-- Row -->
<form class="row align-items-stretch" action="<?php echo url("admin.roles.store") ?>" method="POST">
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
            <label for="key">Key</label>
            <input type="text" name="key" class="form-control <?php echo isset($errors) && !is_null($errors->first("key")) ? "is-invalid" : ""; ?>" id="key" value="<?php echo isset($model) ? $model->get("key") : ""; ?>" aria-describedby="key_error">
            <div id="key_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("key") : ""; ?></div>
          </div>

          <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control <?php echo isset($errors) && !is_null($errors->first("name")) ? "is-invalid" : ""; ?>" id="name" value="<?php echo isset($model) ? $model->get("name") : ""; ?>" aria-describedby="name_error">
            <div id="name_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("name") : ""; ?></div>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>

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