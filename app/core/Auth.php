<?php

namespace MasterStudents\Core;

use Exception;
use MasterStudents\Models\User;

class Auth
{
    public function attempt(User $user, string $password)
    {
        if (password_verify($password, $user->password)) {
            session()->attemptUserSession($user);

            $this->user = $user;

            return true;
        }

        return false;
    }

    public function user()
    {
        return session()->getAuthenticated();
    }

    public function check()
    {
        return session()->isAuthenticated();
    }

    public function logout()
    {
        try {
            session()->flash();

            return true;
        } catch (Exception $e) {
        }

        return false;
    }
}
