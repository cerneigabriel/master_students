<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Users</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
  </ol>
</div>

<!-- Row -->
<div class="row">
  <!-- DataTable with Hover -->
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Records</h6>
        <a class="btn btn-primary btn-sm" href="<?php echo url("admin.users.create") ?>">Create New</a>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover" id="users">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
              <th width="50px">Roles</th>
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
              <th>Roles</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Gender</th>
              <th>Zoom Link</th>
              <th>Actions</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($users as $user) : ?>
              <tr>
                <td><?php echo $user->id ?></td>
                <td>
                  <?php foreach ($user->roles() as $role) : ?>
                    <span class="badge badge-pill badge-info"><?php echo $role->name ?></span>
                  <?php endforeach; ?>
                </td>
                <td><?php echo "$user->first_name $user->last_name" ?></td>
                <td><?php echo $user->email ?></td>
                <td><?php echo $user->phone ?></td>
                <td><?php echo $user->gender === "m" ? "Male" : "Female" ?></td>
                <td><?php echo $user->zoom_link ?></td>
                <td>
                  <form action="<?php echo url("admin.users.delete", ["id" => $user->id]) ?>" method="POST" style="display: inline">
                    <?php echo csrf_input() ?>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash-alt"></i></button>
                  </form>
                  <a href="<?php echo url("admin.users.edit", ["id" => $user->id]) ?>" class="btn btn-success btn-sm"><i class="fas fa-fw fa-edit"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
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

<script src="<?php echo assets("assets/vendor/admin/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo assets("assets/vendor/admin/datatables/dataTables.bootstrap4.min.js") ?>"></script>

<!-- Page level custom scripts -->
<script>
  $(document).ready(function() {
    $('#users').DataTable({});
  });
</script>