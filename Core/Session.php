<?php

namespace MasterStudents\Core;

use Collections\Map;
use ReflectionMethod;
use RuntimeException;

class Session
{
    private static Map $session;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->run();

        static::$session = map($_SESSION);

        return $this;
    }

    /**
     * Run session
     *
     * @return void
     */
    public function run()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }

    /**
     * Call private functions
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
            $reflection = new ReflectionMethod($this, $name);
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
     * Get item from session
     *
     * @param mixed $path
     * @return mixed
     */
    protected function get($path = null)
    {
        if (!is_null($path)) {
            $result = static::$session->toArray();
            $tries = 0;

            foreach (explode(".", $path) as $key) {
                if (isset($result[$key])) {
                    $result = $result[$key];
                    if (++$tries === count(explode(".", $path))) return $result;
                }
            }

            return false;
        }

        return $this->all();
    }

    /**
     * Set values in sessions
     *
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    protected function set($key, $value)
    {
        static::$session->set($key, $value);
        $this->sync();

        return $this->get($key);
    }

    /**
     * Check if key exists in session
     *
     * @param mixed $path
     * @return boolean
     */
    protected function has($path)
    {
        $result = static::$session->toArray();
        $tries = 0;

        foreach (explode(".", $path) as $key) {
            if (isset($result[$key])) {
                $result = $result[$key];
                $tries++;
            }
        }

        return $tries === count(explode(".", $path));
    }

    /**
     * Forget a value in session
     *
     * @param mixed $key
     * @return bool
     */
    protected function forget($key): bool
    {
        $result = static::$session->toArray();

        if (isset($result[$key])) {
            unset($result[$key]);

            static::$session = map($result);
            $this->sync();

            return true;
        }

        return false;
    }

    /**
     * Get all items from session as collection
     *
     * @return Collections\Map
     */
    protected function all(): Map
    {
        return static::$session;
    }

    /**
     * Sync variables from collection to $_SESSION it self and database data collection
     *
     * @return mixed
     */
    private function sync()
    {
        $_SESSION = static::$session->toArray();

        return $this;
    }

    /**
     * Destroy session completely
     *
     * @return Session
     */
    protected function destroy(): Session
    {
        session_destroy();

        static::$session = map();

        return $this;
    }
}
