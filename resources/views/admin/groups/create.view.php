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
        <h4 class="mb-3">Group <span id="abberviation"><?php echo map($specialities)->first()->abbreviation ?></span><span id="group_name"><?php echo isset($model) ? $model->get("name") : ""; ?></span></h4>

        <div class="form-group">
          <label class="form-label" for="speciality_id">Speciality</label>
          <select class="form-control <?php echo isset($errors) && !is_null($errors->first("speciality_id")) ? "is-invalid" : ""; ?>" name="speciality_id" id="speciality_id" aria-describedby="speciality_id_error">
            <?php foreach ($specialities as $speciality) : ?>
              <option value="<?php echo $speciality->id ?>"><?php echo "$speciality->name" ?></option>
            <?php endforeach; ?>
          </select>
          <div id="speciality_id_error" class="invalid-feedback"><?php echo isset($errors) ? $errors->first("speciality_id") : ""; ?></div>
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

<script>
  const specialities = <?php echo json_encode(map($specialities)->map(fn ($i) => $i->toArray())->toArray()) ?>;

  $(document).ready(function() {
    $("#speciality_id").select2();
    $("#year_input .input-group.date").datepicker({
      endDate: (new Date()).getFullYear().toString(),
      minViewMode: "years",
      maxViewMode: "years",
      startView: "years",
      format: "yyyy",
      autoclose: true,
      todayHighlight: true,
      todayBtn: "linked",
    });

    $(document).on("change", "#speciality_id", function() {
      var speciality = specialities.find(item => item.id === parseInt($(this).val()));
      
      if (speciality) {
        $("#abberviation").text(speciality.abbreviation);
      }
    });

    $(document).on("keyup", "#name", function() {
      $("#group_name").text($(this).val());
    });
  });
</script>

<style>
  .select2 {
    display: block;
  }
</style>