<?php

/**
 * Admin Permissions Routes
 */
router()->get("/admin/permissions", [
  "controller" => "Admin\PermissionsController::index",
  "name" => "admin.permissions.index",
  "middlewares" => $middlewares
]);

router()->get("/admin/permissions/create", [
  "controller" => "Admin\PermissionsController::create",
  "name" => "admin.permissions.create",
  "middlewares" => $middlewares
]);

router()->post("/admin/permissions", [
  "controller" => "Admin\PermissionsController::store",
  "name" => "admin.permissions.store",
  "middlewares" => $middlewares
]);

router()->get("/admin/permissions/{id}/edit", [
  "controller" => "Admin\PermissionsController::edit",
  "name" => "admin.permissions.edit",
  "middlewares" => $middlewares
]);

router()->post("/admin/permissions/{id}", [
  "controller" => "Admin\PermissionsController::update",
  "name" => "admin.permissions.update",
  "middlewares" => $middlewares
]);

router()->post("/admin/permissions/{id}/delete", [
  "controller" => "Admin\PermissionsController::delete",
  "name" => "admin.permissions.delete",
  "middlewares" => $middlewares
]);
