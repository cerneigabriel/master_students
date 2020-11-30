<?php


/**
 * Admin Users Routes
 */
router()->get("/admin/users", getAdminRouteDetails("Admin\UsersController::index", "admin.users.index"));

router()->get("/admin/users/create", getAdminRouteDetails("Admin\UsersController::create", "admin.users.create"));

router()->post("/admin/users", getAdminRouteDetails("Admin\UsersController::store", "admin.users.store"));

router()->get("/admin/users/{id}/edit", getAdminRouteDetails("Admin\UsersController::edit", "admin.users.edit"));

router()->post("/admin/users/{id}", getAdminRouteDetails("Admin\UsersController::update", "admin.users.update"));

router()->post("/admin/users/{id}/delete", getAdminRouteDetails("Admin\UsersController::delete", "admin.users.delete"));

router()->post("/admin/users/{id}/change_password", getAdminRouteDetails("Admin\UsersController::changePassword", "admin.users.change_password"));


/**
 * User Roles Management Routes
 */
router()->post("/admin/users/{user_id}/roles/{role_id}/detach", getAdminRouteDetails("Admin\UsersController::detachRole", "admin.users.detach_role"));

router()->post("/admin/users/{user_id}/roles/detach", getAdminRouteDetails("Admin\UsersController::detachRoles", "admin.users.detach_roles"));


router()->post("/admin/users/{user_id}/roles/{role_id}/attach", getAdminRouteDetails("Admin\UsersController::attachRole", "admin.users.attach_role"));

router()->post("/admin/users/{user_id}/roles/attach", getAdminRouteDetails("Admin\UsersController::attachRoles", "admin.users.attach_roles"));


router()->post("/admin/users/{user_id}/roles/update", getAdminRouteDetails("Admin\UsersController::updateRoles", "admin.users.update_roles"));


/**
 * User Permissions Management Routes
 */
router()->post("/admin/users/{user_id}/permissions/{permission_id}/detach", getAdminRouteDetails("Admin\UsersController::detachPermission", "admin.users.detach_permission"));

router()->post("/admin/users/{user_id}/permissions/detach", getAdminRouteDetails("Admin\UsersController::detachPermissions", "admin.users.detach_permissions"));


router()->post("/admin/users/{user_id}/permissions/{permission_id}/attach", getAdminRouteDetails("Admin\UsersController::attachPermission", "admin.users.attach_permission"));

router()->post("/admin/users/{user_id}/permissions/attach", getAdminRouteDetails("Admin\UsersController::attachPermissions", "admin.users.attach_permissions"));


router()->post("/admin/users/{user_id}/permissions/update", getAdminRouteDetails("Admin\UsersController::updatePermissions", "admin.users.update_permissions"));
