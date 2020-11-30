<?php

namespace MasterStudents\Actions\SecurityManagement;

use Carbon\Carbon;
use Collections\Map;
use MasterStudents\Models\Role;

trait UserRolesManagement
{
    /**
     * Get All Roles as Map Collection
     */
    private function allRoles()
    {
        return map(
            Role::query(function ($query) {
                return $query
                    ->select("roles.*")
                    ->innerJoin('user_role')
                    ->on(['roles.id' => 'user_role.role_id'])
                    ->where('user_role.user_id', $this->{$this->primaryKey});
            })->get()
        );
    }

    /**
     * Attach Role to user
     *
     * @return void
     */
    public function attachRole(Role $role)
    {
        if (!$this->hasRole($role)) {
            $this->db
                ->insert("user_role")
                ->values([
                    "user_id" => $this->{$this->primaryKey},
                    "role_id" => $role->{$role->primaryKey},
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "updated_at" => Carbon::now()->toDateTimeString(),
                ])
                ->run();
        }
    }

    /**
     * Update roles list for current user
     *
     * @param Map $roles
     * @return void
     */
    public function updateRoles(Map $roles)
    {
        $all_roles_ids = map(Role::all())->map(fn ($v) => $v->{$v->primaryKey})->toArray();
        $update_roles_ids = $roles->map(fn ($v) => $v->{$v->primaryKey})->toArray();
        $detach_roles = map(array_diff($all_roles_ids, $update_roles_ids))->map(fn ($r) => Role::find($r));

        $this->attachRoles($roles);
        $this->detachRoles($detach_roles);
    }

    /**
     * Attach Role by key to user
     *
     * @return void
     */
    public function attachRoleKey(string $key)
    {
        $role = Role::query(fn ($q) => $q->where("key", $key))->first();

        $this->attachRole($role);
    }

    /**
     * Attach multiple roles
     *
     * @param Map[Role] $roles
     * @return void
     */
    public function attachRoles(Map $roles)
    {
        $roles->each(fn ($role) => $this->attachRole($role));
    }

    /**
     * Attach multiple roles by key
     *
     * @param Map[string] $roles
     * @return void
     */
    public function attachRolesKeys(Map $keys)
    {
        $keys->each(fn ($role) => $this->attachRoleKey($role));
    }

    /**
     * Detach Role to user
     *
     * @return void
     */
    public function detachRole(Role $role)
    {
        if ($this->hasRole($role)) {
            $this->db
                ->table("user_role")
                ->delete()
                ->where("user_id", $this->{$this->primaryKey})
                ->where("role_id", $role->{$role->primaryKey})
                ->run();
        }
    }

    /**
     * Detach Role by key to user
     *
     * @return void
     */
    public function detachRoleKey(string $key)
    {
        $role = Role::query(fn ($q) => $q->where("key", $key))->first();

        $this->detachRole($role);
    }

    /**
     * Detach multiple roles
     *
     * @param Map[Role] $roles
     * @return void
     */
    public function detachRoles(Map $roles)
    {
        $roles->each(fn ($role) => $this->detachRole($role));
    }

    /**
     * Detach multiple roles by key
     *
     * @param Map[string] $roles
     * @return void
     */
    public function detachRolesKeys(Map $keys)
    {
        $keys->each(fn ($role) => $this->detachRoleKey($role));
    }

    /**
     * Get all roles
     *
     * @return array
     */
    public function roles(): array
    {
        return $this->allRoles()->toArray();
    }

    /**
     * Check if user has specific role
     *
     * @param Role $role
     * @return boolean
     */
    public function hasRole(Role $role): bool
    {
        return in_array($role->{$role->primaryKey}, map($this->roles())->map(fn ($v) => $v->{$v->primaryKey})->toArray());
    }

    /**
     * Check if user has specific role by it's key
     *
     * @param string $key
     * @return boolean
     */
    public function hasRoleKey(string $key)
    {
        return in_array($key, map($this->roles())->map(fn ($v) => $v->key)->toArray());
    }

    /**
     * Check if user has specific roles
     *
     * @param Map $roles
     * @return boolean
     */
    public function hasRoles(Map $roles)
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) return false;
        }

        return true;
    }

    /**
     * Check if user has specific role by it's key
     *
     * @param string $key
     * @return boolean
     */
    public function hasRolesKeys(Map $keys)
    {
        foreach ($keys as $key) {
            if (!$this->hasRoleKey($key)) return false;
        }

        return true;
    }
}
