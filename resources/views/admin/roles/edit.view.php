<?php

use MasterStudents\Core\Session;
use MasterStudents\Models\Role;

$role = Role::find($model->get("id"));

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit #<?php echo $model->get("id") ?></h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url("admin.roles.index"); ?>">Roles</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</div>

<!-- Row -->
<div class="row align-items-stretch">
  <!-- Basic information -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Basic information</h6>
      </div>
      <div class="card-body">
        <form action="<?php echo url("admin.roles.update", ["id" => $model->get("id")]) ?>" method="POST">
          <?php echo csrf_input() ?>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="key">Key</label>
              <input type="text" readonly class="form-control" id="key" value="<?php echo isset($model) ? $model->get("key") : ""; ?>">
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
        </form>
      </div>
    </div>
  </div>

  <!-- Permissions -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Permissions</h6>
      </div>
      <div class="card-body">
        <form action="<?php echo url("admin.roles.update_permissions", ["role_id" => $model->get("id")]) ?>" method="POST">
          <?php echo csrf_input() ?>
          <div class="form-group">
            <label for="permissions">Permissions</label>
            <select class="form-control d-block" name="permissions[]" multiple="multiple" id="permissions_input">
              <?php foreach ($permissions as $permission) : ?>
                <option value="<?php echo $permission->id ?>" <?php echo $role->hasPermission($permission) ? "selected" : "" ?>><?php echo $permission->name ?></option>
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
<!--Row-->

<script>
  $(document).ready(function() {
    $('#permissions_input').select2();
  });
</script>

<style>
  .select2 {
    display: block;
  }
</style>