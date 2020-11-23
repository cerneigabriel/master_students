<?php

/**
 * Admin Users Routes
 */
router()->get("/admin/users", [
  "controller" => "Admin\UsersController::index",
  "name" => "admin.users.index",
  "middlewares" => $middlewares
]);

router()->get("/admin/users/create", [
  "controller" => "Admin\UsersController::create",
  "name" => "admin.users.create",
  "middlewares" => $middlewares
]);

router()->post("/admin/users", [
  "controller" => "Admin\UsersController::store",
  "name" => "admin.users.store",
  "middlewares" => $middlewares
]);

router()->get("/admin/users/{id}/edit", [
  "controller" => "Admin\UsersController::edit",
  "name" => "admin.users.edit",
  "middlewares" => $middlewares
]);

router()->post("/admin/users/{id}", [
  "controller" => "Admin\UsersController::update",
  "name" => "admin.users.update",
  "middlewares" => $middlewares
]);

router()->post("/admin/users/{id}/delete", [
  "controller" => "Admin\UsersController::delete",
  "name" => "admin.users.delete",
  "middlewares" => $middlewares
]);

// Detach role or roles
router()->post("/admin/users/{user_id}/roles/{role_id}/detach", [
  "controller" => "Admin\UsersController::detachRole",
  "name" => "admin.users.detach_role",
  "middlewares" => $middlewares
]);

router()->post("/admin/users/{user_id}/roles/detach", [
  "controller" => "Admin\UsersController::detachRoles",
  "name" => "admin.users.detach_roles",
  "middlewares" => $middlewares
]);

// Attach role or roles
router()->post("/admin/users/{user_id}/roles/{role_id}/attach", [
  "controller" => "Admin\UsersController::attachRole",
  "name" => "admin.users.attach_role",
  "middlewares" => $middlewares
]);

router()->post("/admin/users/{user_id}/roles/attach", [
  "controller" => "Admin\UsersController::attachRoles",
  "name" => "admin.users.attach_roles",
  "middlewares" => $middlewares
]);
