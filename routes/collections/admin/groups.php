<?php

/**
 * Admin Groups Routes
 */
router()->get("{$admin_prefix}/groups", getAdminRouteDetails("GroupsController::index", "groups.index"));

router()->get("{$admin_prefix}/groups/create", getAdminRouteDetails("GroupsController::create", "groups.create"));

router()->post("{$admin_prefix}/groups", getAdminRouteDetails("GroupsController::store", "groups.store"));

router()->get("{$admin_prefix}/groups/{id}/edit", getAdminRouteDetails("GroupsController::edit", "groups.edit"));

router()->post("{$admin_prefix}/groups/{id}", getAdminRouteDetails("GroupsController::update", "groups.update"));

router()->post("{$admin_prefix}/groups/{id}/delete", getAdminRouteDetails("GroupsController::delete", "groups.delete"));


// Detach user or users
router()->post("{$admin_prefix}/groups/{group_id}/users/{user_id}/detach", getAdminRouteDetails("GroupsController::detachUser", "groups.detach_user"));

router()->post("{$admin_prefix}/groups/{group_id}/users/detach", getAdminRouteDetails("GroupsController::detachUsers", "groups.detach_users"));

// Attach user or users
router()->post("{$admin_prefix}/groups/{group_id}/users/{user_id}/attach", getAdminRouteDetails("GroupsController::attachUser", "groups.attach_user"));

router()->post("{$admin_prefix}/groups/{group_id}/users/attach", getAdminRouteDetails("GroupsController::attachUsers", "groups.attach_users"));


router()->post("{$admin_prefix}/groups/{group_id}/users/update", getAdminRouteDetails("GroupsController::updateUsers", "groups.update_users"));
