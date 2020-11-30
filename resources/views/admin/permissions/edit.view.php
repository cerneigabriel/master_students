<?php

use MasterStudents\Core\Session;

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit #<?php echo $model->get("id") ?></h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url("admin.permissions.index"); ?>">Permissions</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</div>

<!-- Row -->
<form class="row align-items-stretch" action="<?php echo url("admin.permissions.update", ["id" => $model->get("id")]) ?>" method="POST">
  <?php echo csrf_input() ?>

  <!-- Basic information -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Basic information</h6>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="key">Key</label>
          <input type="text" readonly class="form-control" id="key" value="<?php echo isset($model) ? $model->get("key") : ""; ?>">
        </div>

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control <?php echo isset($errors) && !is_null($errors->first("name")) ? "is-invalid" : ""; ?>" id="name" value="<?php echo isset($model) ? $model->get("name") : ""; ?>" aria-describedby="name_error">
          <div id="name_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("name") : ""; ?></div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!--Row-->
