<?php

namespace MasterStudents\Actions\SecurityManagement;

use Carbon\Carbon;
use Collections\Map;
use MasterStudents\Models\User;

trait GroupUsersManagement
{
  /**
   * Get All Users as Map Collection
   */
  private function allUsers()
  {
    return map(
      User::query(function ($query) {
        return $query
          ->select("users.*")
          ->innerJoin('group_user')
          ->on(['users.id' => 'group_user.user_id'])
          ->onWhere('group_user.group_id', $this->{$this->primaryKey});
      })->get()
    );
  }

  /**
   * Attach User to Group
   *
   * @param User $user
   * @return void
   */
  public function attachUser(User $user)
  {
    if (!$this->hasuser($user)) {
      $this->db
        ->insert("group_user")
        ->values([
          "group_id" => $this->{$this->primaryKey},
          "user_id" => $user->{$user->primaryKey},
          "created_at" => Carbon::now()->toDateTimeString(),
          "updated_at" => Carbon::now()->toDateTimeString(),
        ])
        ->run();
    }
  }

  /**
   * Detach User to user
   *
   * @return void
   */
  public function detachUser(User $user)
  {
    if ($this->hasUser($user)) {
      $this->db
        ->table("group_user")
        ->delete()
        ->where("group_id", $this->{$this->primaryKey})
        ->where("user_id", $user->{$user->primaryKey})
        ->run();
    }
  }

  /**
   * Update users list for current group
   *
   * @param Map[User] $users
   * @return void
   */
  public function updateUsers(Map $users)
  {
    $detach_users = map(User::all())->filter(fn ($v) => !in_array($v->{$v->primaryKey}, $users->map(fn ($u) => $u->{$u->primaryKey})->toArray()));

    $this->attachUsers($users);
    $this->detachUsers($detach_users);
  }

  /**
   * Attach multiple users
   *
   * @param Map[User] $users
   * @return void
   */
  public function attachUsers(Map $users)
  {
    $users->each(fn ($u) => $this->attachUser($u));
  }

  /**
   * Detach multiple users
   *
   * @param Map[Student] $users
   * @return void
   */
  public function detachUsers(Map $users)
  {
    $users->each(fn ($u) => $this->detachUser($u));
  }

  /**
   * Get all Users
   *
   * @return array[User]
   */
  public function users(): array
  {
    return $this->allUsers()->toArray();
  }

  /**
   * Check if Group has specific User
   *
   * @param User $user
   * @return boolean
   */
  public function hasUser(User $user): bool
  {
    return in_array($user->{$user->primaryKey}, $this->allUsers()->map(fn ($v) => $v->{$v->primaryKey})->toArray());
  }

  /**
   * Check if Group has specific Users
   *
   * @param Map[User] $users
   * @return boolean
   */
  public function hasUsers(Map $users)
  {
    foreach ($users->toArray() as $user)
      if (!$this->hasUser($user)) return false;

    return true;
  }
}
