<?php

use MasterStudents\Core\Session;

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Create Permission</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url("admin.permissions.index"); ?>">Permissions</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
  </ol>
</div>

<!-- Row -->
<form class="row align-items-stretch" action="<?php echo url("admin.permissions.store") ?>" method="POST">
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
          <input type="text" name="key" class="form-control <?php echo isset($errors) && !is_null($errors->first("key")) ? "is-invalid" : ""; ?>" id="key" value="<?php echo isset($model) ? $model->get("key") : ""; ?>" aria-describedby="key_error">
          <div id="key_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("key") : ""; ?></div>
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

<script>
  var editedName = false;

  $(document).on("keyup", "#key", function() {
    if (!editedName) {
      var name = $(this).val().split("_").join(" ").toLowerCase().replace(/\b./g, a => a.toUpperCase());

      $("#name").val(name);
    }
  });

  $(document).on("keyup", "#name", () => editedName = true);
</script>