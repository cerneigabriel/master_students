<?php

use MasterStudents\Core\Session;
use MasterStudents\Models\Group;

$group = Group::find($model->get("id"));

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Edit #<?php echo $model->get("id") ?></h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item"><a href="<?php echo url("admin.groups.index"); ?>">Groups</a></li>
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
        <form action="<?php echo url("admin.groups.update", ["id" => $model->get("id")]) ?>" method="POST">
          <?php echo csrf_input() ?>
          <div class="form-group">
            <label for="user_input">Leader</label>
            <select class="form-control d-block <?php echo isset($errors) && !is_null($errors->first("user_id")) ? "is-invalid" : ""; ?>" name="user_id" id="user_input" value="<?php echo $group->user_id ?>" aria-describedby="user_id_error">
              <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user->id ?>" <?php echo $model->get("user_id") === $user->id ? "selected" : "" ?>><?php echo "$user->first_name $user->last_name" ?></option>
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
              <input type="text" name="year" class="form-control <?php echo isset($errors) && !is_null($errors->first("year")) ? "is-invalid" : ""; ?>" id="year" aria-describedby="year_error">
              <div id="year_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("year") : ""; ?></div>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- Students -->
  <div class="col-lg-6 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Students</h6>
      </div>
      <div class="card-body">
        <form action="<?php echo url("admin.groups.update_users", ["group_id" => $model->get("id")]) ?>" method="POST">
          <?php echo csrf_input() ?>
          <div class="form-group">
            <label for="users">Students</label>
            <select class="form-control d-block" name="users[]" multiple="multiple" id="users_input">
              <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user->id ?>" <?php echo $group->hasUser($user) ? "selected" : "" ?>><?php echo "$user->first_name $user->last_name" ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="from-group">
            <button type="submit" class="btn btn-primary">Attach</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Students -->
  <div class="col-lg-12 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Students</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover">
            <thead class="thead-light">
              <tr>
                <th>Id</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Zoom Link</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot class="tfoot-light">
              <tr>
                <th>Id</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Zoom Link</th>
                <th>Actions</th>
              </tr>
            </tfoot>
            <tbody>
              <?php foreach ($group->users() as $user) : ?>
                <tr>
                  <td><?php echo $user->id ?></td>
                  <td><?php echo "$user->first_name $user->last_name" ?></td>
                  <td><?php echo $user->email ?></td>
                  <td><?php echo $user->phone ?></td>
                  <td><?php echo $user->gender === "m" ? "Male" : "Female" ?></td>
                  <td><?php echo $user->zoom_link ?></td>
                  <td>
                  </td>
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

<script>
  $(document).ready(function() {
    $('#user_input').select2();
    $('#users_input').select2();

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

    $('#year_input .input-group.date').datepicker('setDate', "<?php echo isset($model) ? $model->get("year") : ""; ?>");

    $('#users').DataTable();
  });
</script>

<style>
  .select2 {
    display: block;
  }
</style>