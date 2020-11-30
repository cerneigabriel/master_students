<?php

namespace MasterStudents\Actions\SecurityManagement;

use Carbon\Carbon;
use Collections\Map;
use MasterStudents\Models\Permission;

trait UserPermissionsManagement
{
    /**
     * Get All Permissions as Map Collection
     */
    private function allPremissions()
    {
        return map(
            Permission::query(function ($query) {
                return $query
                    ->select("permissions.*")
                    ->innerJoin('user_permission')
                    ->on(['permissions.id' => 'user_permission.permission_id'])
                    ->onWhere('user_permission.user_id', $this->{$this->primaryKey});
            })->get()
        );
    }

    /**
     * Attach Permission to User
     *
     * @return void
     */
    public function attachPermission(Permission $permission)
    {
        if (!$this->hasPermission($permission)) {
            $this->db
                ->insert("user_permission")
                ->values([
                    "user_id" => $this->{$this->primaryKey},
                    "permission_id" => $permission->{$permission->primaryKey},
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ])
                ->run();
        }
    }

    /**
     * Update permissions list for current user
     *
     * @param Map[Permission] $permissions
     * @return void
     */
    public function updatePermissions(Map $permissions)
    {
        $all_permissions_ids = map(Permission::all())->map(fn ($v) => $v->{$v->primaryKey})->toArray();
        $update_permissions_ids = $permissions->map(fn ($v) => $v->{$v->primaryKey})->toArray();
        $detach_permissions = map(array_diff($all_permissions_ids, $update_permissions_ids))->map(fn ($r) => Permission::find($r));

        $this->attachPermissions($permissions);
        $this->detachPermissions($detach_permissions);
    }

    /**
     * Attach Permission by key to User
     *
     * @return void
     */
    public function attachPermissionKey(string $key)
    {
        $permission = Permission::query(fn ($q) => $q->where("key", $key))->first();

        $this->attachPermission($permission);
    }

    /**
     * Attach multiple permissions
     *
     * @param Map[Permission] $permissions
     * @return void
     */
    public function attachPermissions(Map $permissions)
    {
        $permissions->each(fn ($permission) => $this->attachPermission($permission));
    }

    /**
     * Attach multiple permissions by key
     *
     * @param Map[string] $permissions
     * @return void
     */
    public function attachPermissionsKeys(Map $keys)
    {
        $keys->each(fn ($permission) => $this->attachPermissionKey($permission));
    }

    /**
     * Detach Permission to user
     *
     * @return void
     */
    public function detachPermission(Permission $permission)
    {
        if ($this->hasPermission($permission)) {
            $this->db
                ->table("user_permission")
                ->delete()
                ->where("user_id", $this->{$this->primaryKey})
                ->where("permission_id", $permission->{$permission->primaryKey})
                ->run();
        }
    }

    /**
     * Detach Permission by key to user
     *
     * @return void
     */
    public function detachPermissionKey(string $key)
    {
        $permission = Permission::query(fn ($q) => $q->where("key", $key))->first();

        $this->detachPermission($permission);
    }

    /**
     * Detach multiple roles
     *
     * @param Map[Permission] $permissions
     * @return void
     */
    public function detachPermissions(Map $permissions)
    {
        $permissions->each(fn ($permission) => $this->detachPermission($permission));
    }

    /**
     * Detach multiple roles by key
     *
     * @param Map[string] $permissions
     * @return void
     */
    public function detachPermissionsKeys(Map $keys)
    {
        $keys->each(fn ($permission) => $this->detachPermissionKey($permission));
    }

    /**
     * Get all Permissions
     *
     * @return array[Permission]
     */
    public function permissions(): array
    {
        return $this->allPremissions()->toArray();
    }

    /**
     * Check if Permission has specific Permission
     *
     * @param Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission): bool
    {
        return in_array($permission->id, map($this->all_permissions())->map(fn ($v) => $v->{$v->primaryKey})->toArray());
    }

    /**
     * Check if Permission has specific Permission by it's key
     *
     * @param string $key
     * @return boolean
     */
    public function hasPermissionKey(string $key)
    {
        return in_array($key, map($this->all_permissions())->map(fn ($v) => $v->key)->toArray());
    }

    /**
     * Check if Permission has specific Permissions
     *
     * @param Map[Permission] $permissions
     * @return boolean
     */
    public function hasPermissions(Map $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) return false;
        }

        return true;
    }

    /**
     * Check if Permission has specific Permissions by it's key
     *
     * @param Map[string] $key
     * @return boolean
     */
    public function hasPermissionsKeys(Map $keys)
    {
        foreach ($keys as $key) {
            if (!$this->hasPermissionKey($key)) return false;
        }

        return true;
    }

    /**
     * Check if He/She has specific permission/s
     *
     * @param string | array $permission
     * @return boolean
     */
    public function can($permission): bool
    {
        if (is_string($permission))
            return $this->hasPermissionKey($permission);
        elseif (is_array($permission))
            return $this->hasPermissionsKeys(map($permission));
    }
}
