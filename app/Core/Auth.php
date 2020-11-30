<?php

namespace MasterStudents\Core;

use Exception;
use MasterStudents\Models\User;
use MasterStudents\Models\UserSession;
use Rakit\Validation\Rules\Nullable;
use ReflectionMethod;
use RuntimeException;

class Auth
{
    public static string $CSRF_TOKEN;
    public static UserSession $user_session;
    public static User $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->checkCSRFToken();
        $this->checkUserSession();

        return $this;
    }

    /**
     * Destructor
     */
    private function reset()
    {
        Session::destroy();
    }

    /**
     * Check if CSRF TOKEN exists, if not
     * it will be generated automatically
     * and saved in session
     *
     * @return void
     */
    private function checkCSRFToken()
    {
        if (Session::has("_token")) static::$CSRF_TOKEN = Session::get("_token");
        else {
            static::$CSRF_TOKEN = UserSession::generateToken();
            Session::set("_token", static::$CSRF_TOKEN);
        }
    }

    /**
     * Check if user session exists
     * and save it as a property in Auth
     *
     * @return void
     */
    private function checkUserSession()
    {
        $user_session = UserSession::query(fn ($q) => $q->where("token", static::$CSRF_TOKEN)->where("active", true))->first();

        if (!is_null($user_session)) {
            static::$user_session = $user_session;
            static::$user = User::find($user_session->user_id);
        }
    }

    /**
     * Call protected functions
     *
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        /**
         * Look for Command method
         */
        if (method_exists(__CLASS__, $name)) {
            $reflection = new ReflectionMethod(__CLASS__, $name);
            if ($reflection->isPrivate()) {
                throw new RuntimeException("The called method is not accessable.");
            }
            /**
             * Run the command
             */
            return $this->$name(...$arguments);
        }
    }

    /**
     * Call methods statically
     *
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        /**
         * Look for Command method
         */
        if (method_exists(__CLASS__, $name)) {
            $reflection = new ReflectionMethod(__CLASS__, $name);
            if ($reflection->isPrivate()) {
                throw new RuntimeException("The called method is not accessable.");
            }
            /**
             * Run the command
             */
            return (new self())->$name(...$arguments);
        }
    }

    /**
     * Try to login user by email/username and password
     *
     * @param string $email_username
     * @param string $password
     * @return void
     */
    protected function loginAttempt(string $email_username, string $password, bool $remember_me = false)
    {
        $user = User::query(fn ($query) => ($query->where("email", $email_username)->orWhere("username", $email_username)))->first();

        if (!is_null($user) && Hash::check($password, $user->password)) {
            static::$user_session = UserSession::login($user, static::$CSRF_TOKEN, $remember_me);
            static::$user = $user;

            return true;
        }

        return false;
    }

    /**
     * Get authenticated user
     *
     * @return User|null
     */
    protected function user()
    {
        return static::$user ?? null;
    }

    /**
     * Get authenticated user session
     *
     * @return UserSession|null
     */
    protected function user_session()
    {
        return static::$user_session ?? null;
    }

    /**
     * Check if user exists
     *
     * @return bool
     */
    protected function check(): bool
    {
        return
            !is_null($this->user()) &&
            !is_null($this->user_session());
    }

    /**
     * Try to logout user passing a variable
     * instance of User as a parameter
     *
     * @param User $user
     * @return void
     */
    protected function logoutAttempt()
    {
        if ($this->check()) {
            $this->reset();
            $this->user_session()->logout();
            return true;
        }

        return false;
    }
}
