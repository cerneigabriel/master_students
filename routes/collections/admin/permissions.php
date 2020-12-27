<?php

/**
 * Admin Permissions Routes
 */
router()->get("{$admin_prefix}/permissions", getAdminRouteDetails("PermissionsController::index", "permissions.index"));

router()->get("{$admin_prefix}/permissions/create", getAdminRouteDetails("PermissionsController::create", "permissions.create"));

router()->post("{$admin_prefix}/permissions", getAdminRouteDetails("PermissionsController::store", "permissions.store"));

router()->get("{$admin_prefix}/permissions/{id}/edit", getAdminRouteDetails("PermissionsController::edit", "permissions.edit"));

router()->post("{$admin_prefix}/permissions/{id}", getAdminRouteDetails("PermissionsController::update", "permissions.update"));

router()->post("{$admin_prefix}/permissions/{id}/delete", getAdminRouteDetails("PermissionsController::delete", "permissions.delete"));
