<?php

/**
 * 
 * Migrations
 */
$run_migrations = true;

require_once "server.php";

$app->migrations->migrate();

// $db = $database->dbm;

// $users = $db->database("default")->table("users");

// $users->insertOne([
//     "username" => "cerneigabriel",
//     "first_name" => "Cernei",
//     "last_name" => "Gabriel",
//     "email" => "cerneigabriel@gmail.com",
//     "password" => md5("C4KT85540"),
//     "remember_token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
//     "birthdate" => "2001-11-13",
//     "phone" => "078398000",
//     "company" => "PoliLingua",
//     "speciality" => "Laravel Back-End Developer",
//     "gender" => "m",
//     "notes" => "HEllo World",
// ]);
