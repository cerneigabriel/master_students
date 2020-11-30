<?php

namespace MasterStudents\Actions\SecurityManagement;

use Carbon\Carbon;
use Collections\Map;
use MasterStudents\Models\Permission;

trait RolePermissionsManagement
{
    /**
     * Get All Permissions as Map Collection
     */
    private function allPermissions()
    {
        return map(
            Permission::query(function ($query) {
                return $query
                    ->select("permissions.*")
                    ->innerJoin('role_permission')
                    ->on(['permissions.id' => 'role_permission.permission_id'])
                    ->where('role_permission.role_id', $this->{$this->primaryKey});
            })->get()
        );
    }

    /**
     * Attach Permission to Role
     *
     * @return void
     */
    public function attachPermission(Permission $permission)
    {
        if (!$this->hasPermission($permission)) {
            $this->db
                ->insert("role_permission")
                ->values([
                    "role_id" => $this->{$this->primaryKey},
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
        $detach_permissions = map(array_diff($all_permissions_ids, $update_permissions_ids))->map(fn ($p) => Permission::find($p));

        $this->attachPermissions($permissions);
        $this->detachPermissions($detach_permissions);
    }

    /**
     * Attach Permission by key to Role
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
                ->table("role_permission")
                ->delete()
                ->where("role_id", $this->{$this->primaryKey})
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
        return $this->allPermissions()->toArray();
    }

    /**
     * Check if Permission has specific Permission
     *
     * @param Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission): bool
    {
        return in_array($permission->id, $this->allPermissions()->map(fn ($v) => $v->{$v->primaryKey})->toArray());
    }

    /**
     * Check if Permission has specific Permission by it's key
     *
     * @param string $key
     * @return boolean
     */
    public function hasPermissionKey(string $key)
    {
        return in_array($key, $this->allPermissions()->map(fn ($v) => $v->key)->toArray());
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
}
