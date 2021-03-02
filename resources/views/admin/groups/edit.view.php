<?php

use MasterStudents\Core\Session;
use MasterStudents\Models\Group;
use MasterStudents\Models\GroupUserStatus;

$group = Group::find($model->get("id"));
$group_user_status_invited = GroupUserStatus::query(fn ($q) => $q->where("key", "invited"))->first();
$group_user_status_active = GroupUserStatus::query(fn ($q) => $q->where("key", "active"))->first();

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
          <h4 class="mb-3">Group <span id="abberviation"><?php echo map($specialities)->first()->abbreviation ?></span><span id="group_name"><?php echo isset($model) ? $model->get("name") : ""; ?></span></h4>

          <table class="table">
            <tbody>
              <tr>
                <th scope="row">Speciality</th>
                <td width="50%"><?php echo isset($model) ? $model->get("speciality")->name : ""; ?></td>
              </tr>
              <tr>
                <th scope="row">Name</th>
                <td><?php echo isset($model) ? $model->get("name") : ""; ?></td>
              </tr>
              <tr>
                <th scope="row">Year</th>
                <td><?php echo isset($model) ? $model->get("year") : ""; ?></td>
              </tr>
              <tr>
                <th scope="row">Members</th>
                <td><?php echo isset($model) ? map($model->get("members"))->count() : ""; ?></td>
              </tr>
              <tr>
                <th scope="row" style="padding-left: 3.5rem">Active</th>
                <td>
                  <?php
                    echo isset($model) ?
                      map($model->get("members"))
                        ->filter(fn ($item) => $item->group_user_status_id === $group_user_status_active->id)
                        ->count() :
                      "";
                  ?>
                </td>
              </tr>
              <tr>
                <th scope="row" style="padding-left: 3.5rem">Invited</th>
                <td>
                  <?php
                    echo isset($model) ?
                      map($model->get("members"))
                        ->filter(fn ($item) => $item->group_user_status_id === $group_user_status_invited->id)
                        ->count() :
                      "";
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>

  <!-- Students -->
  <div class="col-lg-12 pb-4">
    <div class="card h-100">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Members</h6>
        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#members" id="#members_button">
          <span class="icon text-white-50">
            <i class="fas fa-paper-plane"></i>
          </span>
          <span class="text">Invite more members</span>
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive p-3">
          <table class="table align-items-center table-flush table-hover" id="users">
            <thead class="thead-light">
              <tr>
                <th>Id</th>
                <th>Status</th>
                <th>Role</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot class="tfoot-light">
              <tr>
                <th>Id</th>
                <th>Status</th>
                <th>Role</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Actions</th>
              </tr>
            </tfoot>
            <tbody>
              <?php foreach ($model->get("members") as $member) : ?>
                <tr>
                  <td><?php echo $member->user()->id ?></td>
                  <td>
                    <span class="badge badge-pill badge-primary">
                      <?php echo $member->group_user_status()->name ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge badge-pill badge-primary">
                      <?php echo $member->role()->name ?>
                    </span>
                  </td>
                  <td><?php echo "{$member->user()->first_name} {$member->user()->last_name}" ?></td>
                  <td><?php echo $member->user()->email ?></td>
                  <td><?php echo $member->user()->phone ?></td>
                  <td><?php echo $member->user()->gender === "m" ? "Male" : "Female" ?></td>
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

<div class="modal fade" id="members" tabindex="-1" role="dialog" aria-labelledby="membersTitle" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="membersTitle">Members Invitations</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo url("admin.groups.invite", ["group_id" => $model->get("id")]) ?>" method="POST">
        <div class="modal-body">
          <?php echo csrf_input() ?>
          <div class="form-group">
            <label for="users">Members</label>
            <select class="form-control d-block" name="users[]" multiple="multiple" id="users_input">

              <?php foreach ($users as $user) : ?>

                <?php if (!$group->hasUser($user)) : ?>
                  <option value="<?php echo $user->id ?>">
                    <?php echo "$user->email" ?>
                  </option>
                <?php endif; ?>

              <?php endforeach; ?>

            </select>
            <small>They will receive a mail with an invitation to the course.</small>
          </div>
          <div class="form-group">
            <label for="emails">Emails</label>
            <select class="form-control d-block" name="emails[]" multiple="multiple" id="emails_input">

              <?php foreach ($emails as $user) : ?>
                
                <option value="<?php echo $user->id ?>" <?php echo $group->hasUser($user) ? "selected" : "" ?>>
                  <?php echo "$user->email" ?>
                </option>

              <?php endforeach; ?>

            </select>
            <small>They will receive a mail with an invitation to the course.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Invite</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function isEmail(myVar){
    var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');
    return regEmail.test(myVar);
  }

  $(document).ready(function() {
    $('#users_input').select2();
    $('#emails_input').select2({
      tags: true,
      createTag: function (params) {
        if(!isEmail(params.term)){
            return {
                text: params.term,
            };
        }
        return {
          id: params.term,
          text: params.term,
        };
      }
    });

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