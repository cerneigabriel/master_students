<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Groups</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo url("admin.index"); ?>">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Groups</li>
  </ol>
</div>

<!-- Row -->
<div class="row">
  <!-- DataTable with Hover -->
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Records</h6>
        <a class="btn btn-primary btn-sm" href="<?php echo url("admin.groups.create") ?>">Create New</a>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover" id="groups">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
              <th>Leader</th>
              <th>Group</th>
              <th>Year</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Leader</th>
              <th>Group</th>
              <th>Year</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Actions</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($groups as $group) : ?>
              <tr>
                <td><?php echo $group->id ?></td>
                <td><?php echo $group->leader()->first_name . " " . $group->leader()->last_name ?></td>
                <td><?php echo $group->name ?></td>
                <td><?php echo $group->year ?></td>
                <td><?php echo $group->created_at ?></td>
                <td><?php echo $group->updated_at ?></td>
                <td>
                  <form action="<?php echo url("admin.groups.delete", ["id" => $group->id]) ?>" method="POST" style="display: inline">
                    <?php echo csrf_input() ?>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash-alt"></i></button>
                  </form>
                  <a href="<?php echo url("admin.groups.edit", ["id" => $group->id]) ?>" class="btn btn-success btn-sm"><i class="fas fa-fw fa-edit"></i></a>
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
    $('#groups').DataTable();
  });
</script>