<?php

namespace MasterStudents\Models;

use Carbon\Carbon;
use Exception;
use MasterStudents\Core\Model;

class UserSession extends Model
{
  public $table = "sessions";
  public $primaryKey = "id";

  public $timestamps = true;

  public $fillable = [
    "user_id",
    "active",
    "token",
    "remember_token",
    "data",
    "ip",
  ];

  public $casts = [
    "id" => "integer",
    "user_id" => "integer",
    "active" => "boolean",
    "token" => "string",
    "remember_token" => "boolean",
    "data" => "json",
    "ip" => "string",
  ];

  public function user()
  {
    try {
      return $this->query(function ($query) {
        return $query->table("users")->where('id', $this->user_id);
      })->first();
    } catch (Exception $e) {
      return false;
    }
  }

  public static function generateToken()
  {
    $token = bin2hex(random_bytes(64));
    $tokens = map((new self)->repository->select()->columns("token")->fetchAll())->map(fn ($value) => ($value["token"]))->toArray();

    while (in_array($token, $tokens)) $token = bin2hex(random_bytes(64));
    return $token;
  }

  public static function login(User $user, string $token, bool $remember_me = false)
  {
    $same_session = self::query(fn ($q) => $q->where("user_id", $user->id)->where("ip", request()->ip()))->first();

    if (!is_null($same_session))
      return $same_session->update([
        "active" => true,
        "token" => $token,
        "remember_token" => $remember_me,
        "created_at" => Carbon::now()->toDateTimeString()
      ]);

    return self::create([
      "user_id" => $user->id,
      "active" => true,
      "token" => $token,
      "remember_token" => $remember_me,
      "ip" => request()->ip(),
    ]);
  }

  public function updateSessionData(array $data)
  {
    return $this->update([
      "data" => json_encode($data)
    ]);
  }

  public function logout()
  {
    return $this->update([
      "active" => false,
      "token" => null,
      "remember_token" => false,
    ]);
  }
}
