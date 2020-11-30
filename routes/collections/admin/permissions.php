<?php

/**
 * Admin Permissions Routes
 */
router()->get("/admin/permissions", getAdminRouteDetails("Admin\PermissionsController::index", "admin.permissions.index"));

router()->get("/admin/permissions/create", getAdminRouteDetails("Admin\PermissionsController::create", "admin.permissions.create"));

router()->post("/admin/permissions", getAdminRouteDetails("Admin\PermissionsController::store", "admin.permissions.store"));

router()->get("/admin/permissions/{id}/edit", getAdminRouteDetails("Admin\PermissionsController::edit", "admin.permissions.edit"));

router()->post("/admin/permissions/{id}", getAdminRouteDetails("Admin\PermissionsController::update", "admin.permissions.update"));

router()->post("/admin/permissions/{id}/delete", getAdminRouteDetails("Admin\PermissionsController::delete", "admin.permissions.delete"));
