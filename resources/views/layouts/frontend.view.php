<?php

use MasterStudents\Core\Auth;
use MasterStudents\Core\Session;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo csrf_meta() ?>
    <title><?php echo config("app.app_name") ?></title>
    <link href="<?php echo assets("favicon.ico") ?>" rel="icon">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo assets("assets/css/app.css"); ?>">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
    <?php foreach ([
        "error" => "alert alert-danger alert-dismissible fade show",
        "warning" => "alert alert-warning alert-dismissible fade show",
        "success" => "alert alert-success alert-dismissible fade show",
        "info" => "alert alert-info alert-dismissible fade show",
    ] as $type => $alert) : ?>
        <?php if (Session::has($type)) : ?>
            <div class="<?php echo $alert ?>" role="alert">
                <?php
                echo Session::get($type);
                Session::forget($type);
                ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="<?php echo assets("assets/images/icons/master_students_logo.png"); ?>" alt="" height="40px" class="mr-2">
            <?php echo config("app.app_name") ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link <?php echo router()->current_route->name == "home" ? "active" : ""; ?>" href="<?php echo url("home"); ?>">Home</a>
                <a class="nav-link <?php echo router()->current_route->name == "about" ? "active" : ""; ?>" href="<?php echo url("about"); ?>">About</a>
                <a class="nav-link <?php echo router()->current_route->name == "contact.index" ? "active" : ""; ?>" href="<?php echo url("contact.index"); ?>">Contact</a>
            </div>
            <div class="navbar-nav ml-auto">
                <?php if (Auth::check()) : ?>
                    <?php if (Auth::user()->hasRoleKey("super_admin")) : ?>
                        <a class="nav-link <?php echo router()->current_route->name == "auth.login" ? "active" : ""; ?>" href="<?php echo url("admin.index") ?>">Admin</a>
                    <?php endif; ?>
                    <form action="<?php echo url("auth.logout"); ?>" method="post">
                        <?php echo csrf_input() ?>

                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                <?php else : ?>
                    <a class="nav-link <?php echo router()->current_route->name == "auth.login" ? "active" : ""; ?>" href="<?php echo url("auth.login"); ?>">Sign In</a>
                    <a class="nav-link <?php echo router()->current_route->name == "auth.register" ? "active" : ""; ?>" href="<?php echo url("auth.register"); ?>">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    {{ content }}

    <script src="<?php echo assets("assets/js/app.js"); ?>"></script>
</body>

</html>