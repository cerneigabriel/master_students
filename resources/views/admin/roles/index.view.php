<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Roles</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Roles</li>
  </ol>
</div>

<!-- Row -->
<div class="row">
  <!-- DataTable with Hover -->
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Records</h6>
        <a class="btn btn-primary btn-sm" href="<?php echo url("admin.roles.create") ?>">Create New</a>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover" id="roles">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
              <th width="50px">Permissions</th>
              <th>Key</th>
              <th>Name</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Permissions</th>
              <th>Key</th>
              <th>Name</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($roles as $role) : ?>
              <tr>
                <td><?php echo $role->id ?></td>
                <td>
                  <?php foreach ($role->permissions() as $permission) : ?>
                    <span class="badge badge-pill badge-info"><?php echo $permission->name ?></span>
                  <?php endforeach; ?>
                </td>
                <td><?php echo $role->key ?></td>
                <td><?php echo $role->name ?></td>
                <td><?php echo $role->created_at ?></td>
                <td><?php echo $role->updated_at ?></td>
                <td>
                  <form action="<?php echo url("admin.roles.delete", ["id" => $role->id]) ?>" style="display: inline">
                    <?php echo csrf_input() ?>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash-alt"></i></button>
                  </form>
                  <a href="<?php echo url("admin.roles.edit", ["id" => $role->id]) ?>" class="btn btn-success btn-sm"><i class="fas fa-fw fa-edit"></i></a>
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
    $('#roles').DataTable();
  });
</script>