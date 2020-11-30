<?php

/**
 * Admin Roles Routes
 */
router()->get("/admin/roles", getAdminRouteDetails("Admin\RolesController::index", "admin.roles.index"));

router()->get("/admin/roles/create", getAdminRouteDetails("Admin\RolesController::create", "admin.roles.create"));

router()->post("/admin/roles", getAdminRouteDetails("Admin\RolesController::store", "admin.roles.store"));

router()->get("/admin/roles/{id}/edit", getAdminRouteDetails("Admin\RolesController::edit", "admin.roles.edit"));

router()->post("/admin/roles/{id}", getAdminRouteDetails("Admin\RolesController::update", "admin.roles.update"));

router()->post("/admin/roles/{id}/delete", getAdminRouteDetails("Admin\RolesController::delete", "admin.roles.delete"));


// Detach permission or permissions
router()->post("/admin/roles/{role_id}/permissions/{permission_id}/detach", getAdminRouteDetails("Admin\RolesController::detachPermission", "admin.roles.detach_permission"));

router()->post("/admin/roles/{role_id}/permissions/detach", getAdminRouteDetails("Admin\RolesController::detachPermissions", "admin.roles.detach_permissions"));

// Attach permission or permissions
router()->post("/admin/roles/{role_id}/permissions/{permission_id}/attach", getAdminRouteDetails("Admin\RolesController::attachPermission", "admin.roles.attach_permission"));

router()->post("/admin/roles/{role_id}/permissions/attach", getAdminRouteDetails("Admin\RolesController::attachPermissions", "admin.roles.attach_permissions"));


router()->post("/admin/roles/{role_id}/permissions/update", getAdminRouteDetails("Admin\RolesController::updatePermissions", "admin.roles.update_permissions"));
