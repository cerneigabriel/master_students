<?php


/**
 * Admin Users Routes
 */
router()->get("{$admin_prefix}/users", getAdminRouteDetails("UsersController::index", "users.index"));

router()->get("{$admin_prefix}/users/create", getAdminRouteDetails("UsersController::create", "users.create"));

router()->post("{$admin_prefix}/users", getAdminRouteDetails("UsersController::store", "users.store"));

router()->get("{$admin_prefix}/users/{id}/edit", getAdminRouteDetails("UsersController::edit", "users.edit"));

router()->post("{$admin_prefix}/users/{id}", getAdminRouteDetails("UsersController::update", "users.update"));

router()->post("{$admin_prefix}/users/{id}/delete", getAdminRouteDetails("UsersController::delete", "users.delete"));

router()->post("{$admin_prefix}/users/{id}/change_password", getAdminRouteDetails("UsersController::changePassword", "users.change_password"));


/**
 * User Roles Management Routes
 */
router()->post("{$admin_prefix}/users/{user_id}/roles/{role_id}/detach", getAdminRouteDetails("UsersController::detachRole", "users.detach_role"));

router()->post("{$admin_prefix}/users/{user_id}/roles/detach", getAdminRouteDetails("UsersController::detachRoles", "users.detach_roles"));


router()->post("{$admin_prefix}/users/{user_id}/roles/{role_id}/attach", getAdminRouteDetails("UsersController::attachRole", "users.attach_role"));

router()->post("{$admin_prefix}/users/{user_id}/roles/attach", getAdminRouteDetails("UsersController::attachRoles", "users.attach_roles"));


router()->post("{$admin_prefix}/users/{user_id}/roles/update", getAdminRouteDetails("UsersController::updateRoles", "users.update_roles"));


/**
 * User Permissions Management Routes
 */
router()->post("{$admin_prefix}/users/{user_id}/permissions/{permission_id}/detach", getAdminRouteDetails("UsersController::detachPermission", "users.detach_permission"));

router()->post("{$admin_prefix}/users/{user_id}/permissions/detach", getAdminRouteDetails("UsersController::detachPermissions", "users.detach_permissions"));


router()->post("{$admin_prefix}/users/{user_id}/permissions/{permission_id}/attach", getAdminRouteDetails("UsersController::attachPermission", "users.attach_permission"));

router()->post("{$admin_prefix}/users/{user_id}/permissions/attach", getAdminRouteDetails("UsersController::attachPermissions", "users.attach_permissions"));


router()->post("{$admin_prefix}/users/{user_id}/permissions/update", getAdminRouteDetails("UsersController::updatePermissions", "users.update_permissions"));
