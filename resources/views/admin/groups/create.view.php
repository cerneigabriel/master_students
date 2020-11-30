<?php

use MasterStudents\Core\Session;
use MasterStudents\Models\Group;

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Create Group</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url("admin.groups.index"); ?>">Groups</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
  </ol>
</div>

<!-- Row -->
<form class="row align-items-stretch" action="<?php echo url("admin.groups.store") ?>" method="POST">
  <?php echo csrf_input() ?>

  <!-- Basic information -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Basic information</h6>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label" for="user_input">Choose Leader</label>
          <select class="form-control <?php echo isset($errors) && !is_null($errors->first("user_id")) ? "is-invalid" : ""; ?>" name="user_id" id="user_input" aria-describedby="user_id_error">
            <?php foreach ($users as $user) : ?>
              <option value="<?php echo $user->id ?>"><?php echo "$user->first_name $user->last_name" ?></option>
            <?php endforeach; ?>
          </select>
          <div id="user_id_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("user_id") : ""; ?></div>
        </div>

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control <?php echo isset($errors) && !is_null($errors->first("name")) ? "is-invalid" : ""; ?>" id="name" value="<?php echo isset($model) ? $model->get("name") : ""; ?>" aria-describedby="name_error">
          <div id="name_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("name") : ""; ?></div>
        </div>

        <div class="form-group" id="year_input">
          <label for="year">Year</label>
          <div class="input-group date">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
            </div>
            <input type="text" name="year" class="form-control <?php echo isset($errors) && !is_null($errors->first("year")) ? "is-invalid" : ""; ?>" id="year" value="<?php echo isset($model) ? $model->get("year") : ""; ?>" aria-describedby="year_error">
            <div id="year_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("year") : ""; ?></div>
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

<script>
  $(document).ready(function() {
    $('#user_input').select2();
    $('#year_input .input-group.date').datepicker({
      endDate: (new Date()).getFullYear().toString(),
      minViewMode: "years",
      maxViewMode: "years",
      startView: "years",
      format: 'yyyy',
      autoclose: true,
      todayHighlight: true,
      todayBtn: 'linked',
    });
  });
</script>

<style>
  .select2 {
    display: block;
  }
</style>