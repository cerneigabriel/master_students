<?php

/**
 * Admin Groups Routes
 */
router()->get("/admin/groups", getAdminRouteDetails("Admin\GroupsController::index", "admin.groups.index"));

router()->get("/admin/groups/create", getAdminRouteDetails("Admin\GroupsController::create", "admin.groups.create"));

router()->post("/admin/groups", getAdminRouteDetails("Admin\GroupsController::store", "admin.groups.store"));

router()->get("/admin/groups/{id}/edit", getAdminRouteDetails("Admin\GroupsController::edit", "admin.groups.edit"));

router()->post("/admin/groups/{id}", getAdminRouteDetails("Admin\GroupsController::update", "admin.groups.update"));

router()->post("/admin/groups/{id}/delete", getAdminRouteDetails("Admin\GroupsController::delete", "admin.groups.delete"));


// Detach user or users
router()->post("/admin/groups/{group_id}/users/{user_id}/detach", getAdminRouteDetails("Admin\GroupsController::detachUser", "admin.groups.detach_user"));

router()->post("/admin/groups/{group_id}/users/detach", getAdminRouteDetails("Admin\GroupsController::detachUsers", "admin.groups.detach_users"));

// Attach user or users
router()->post("/admin/groups/{group_id}/users/{user_id}/attach", getAdminRouteDetails("Admin\GroupsController::attachUser", "admin.groups.attach_user"));

router()->post("/admin/groups/{group_id}/users/attach", getAdminRouteDetails("Admin\GroupsController::attachUsers", "admin.groups.attach_users"));


router()->post("/admin/groups/{group_id}/users/update", getAdminRouteDetails("Admin\GroupsController::updateUsers", "admin.groups.update_users"));
