<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
  </ol>
</div>

<!-- Row -->
<div class="row">
  <!-- DataTable with Hover -->
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Records</h6>
        <a class="btn btn-primary btn-sm" href="<?php echo url("admin.permissions.create") ?>">Create New</a>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover" id="permissions">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
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
              <th>Key</th>
              <th>Name</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($permissions as $permission) : ?>
              <tr>
                <td><?php echo $permission->id ?></td>
                <td><?php echo $permission->key ?></td>
                <td><?php echo $permission->name ?></td>
                <td><?php echo $permission->created_at ?></td>
                <td><?php echo $permission->updated_at ?></td>
                <td>
                  <form action="<?php echo url("admin.permissions.delete", ["id" => $permission->id]) ?>" method="POST" style="display: inline">
                    <?php echo csrf_input() ?>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash-alt"></i></button>
                  </form>
                  <a href="<?php echo url("admin.permissions.edit", ["id" => $permission->id]) ?>" class="btn btn-success btn-sm"><i class="fas fa-fw fa-edit"></i></a>
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

<script src="<?php echo assets("assets/vendor/admin/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?php echo assets("assets/vendor/admin/datatables/dataTables.bootstrap4.min.js") ?>"></script>

<!-- Page level custom scripts -->
<script>
  $(document).ready(function() {
    $('#permissions').DataTable();
  });
</script>