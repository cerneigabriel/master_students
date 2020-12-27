<?php

use MasterStudents\Core\Auth;

?>
<h1>Dashboard - Hello <?php echo "Teacher " . Auth::user()->first_name; ?></h1>