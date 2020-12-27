<?php

/**
 * Admin Roles Routes
 */
router()->get("{$admin_prefix}/roles", getAdminRouteDetails("RolesController::index", "roles.index"));

router()->get("{$admin_prefix}/roles/create", getAdminRouteDetails("RolesController::create", "roles.create"));

router()->post("{$admin_prefix}/roles", getAdminRouteDetails("RolesController::store", "roles.store"));

router()->get("{$admin_prefix}/roles/{id}/edit", getAdminRouteDetails("RolesController::edit", "roles.edit"));

router()->post("{$admin_prefix}/roles/{id}", getAdminRouteDetails("RolesController::update", "roles.update"));

router()->post("{$admin_prefix}/roles/{id}/delete", getAdminRouteDetails("RolesController::delete", "roles.delete"));


// Detach permission or permissions
router()->post("{$admin_prefix}/roles/{role_id}/permissions/{permission_id}/detach", getAdminRouteDetails("RolesController::detachPermission", "roles.detach_permission"));

router()->post("{$admin_prefix}/roles/{role_id}/permissions/detach", getAdminRouteDetails("RolesController::detachPermissions", "roles.detach_permissions"));

// Attach permission or permissions
router()->post("{$admin_prefix}/roles/{role_id}/permissions/{permission_id}/attach", getAdminRouteDetails("RolesController::attachPermission", "roles.attach_permission"));

router()->post("{$admin_prefix}/roles/{role_id}/permissions/attach", getAdminRouteDetails("RolesController::attachPermissions", "roles.attach_permissions"));


router()->post("{$admin_prefix}/roles/{role_id}/permissions/update", getAdminRouteDetails("RolesController::updatePermissions", "roles.update_permissions"));
