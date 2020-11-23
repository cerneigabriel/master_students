<?php

/**
 * Admin Roles Routes
 */
router()->get("/admin/roles", [
  "controller" => "Admin\RolesController::index",
  "name" => "admin.roles.index",
  "middlewares" => $middlewares
]);

router()->get("/admin/roles/create", [
  "controller" => "Admin\RolesController::create",
  "name" => "admin.roles.create",
  "middlewares" => $middlewares
]);

router()->post("/admin/roles", [
  "controller" => "Admin\RolesController::store",
  "name" => "admin.roles.store",
  "middlewares" => $middlewares
]);

router()->get("/admin/roles/{id}/edit", [
  "controller" => "Admin\RolesController::edit",
  "name" => "admin.roles.edit",
  "middlewares" => $middlewares
]);

router()->post("/admin/roles/{id}", [
  "controller" => "Admin\RolesController::update",
  "name" => "admin.roles.update",
  "middlewares" => $middlewares
]);

router()->post("/admin/roles/{id}/delete", [
  "controller" => "Admin\RolesController::delete",
  "name" => "admin.roles.delete",
  "middlewares" => $middlewares
]);


// Detach permission or permissions
router()->post("/admin/roles/{role_id}/permissions/{permission_id}/detach", [
  "controller" => "Admin\RolesController::detachPermission",
  "name" => "admin.roles.detach_permission",
  "middlewares" => $middlewares
]);

router()->post("/admin/roles/{role_id}/permissions/detach", [
  "controller" => "Admin\RolesController::detachPermissions",
  "name" => "admin.roles.detach_permissions",
  "middlewares" => $middlewares
]);

// Attach permission or permissions
router()->post("/admin/roles/{role_id}/permissions/{permission_id}/attach", [
  "controller" => "Admin\RolesController::attachPermission",
  "name" => "admin.roles.attach_permission",
  "middlewares" => $middlewares
]);

router()->post("/admin/roles/{role_id}/permissions/attach", [
  "controller" => "Admin\RolesController::attachPermissions",
  "name" => "admin.roles.attach_permissions",
  "middlewares" => $middlewares
]);
