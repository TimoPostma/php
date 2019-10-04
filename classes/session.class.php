<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

class Session
{
    public function __construct()
    {
        session_start();
    }
    
    public function save($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public function getAndDelete($key, $default = NULL)
    {
        if (isset($_SESSION[$key]))
        {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
        }
        else
        {
            $value = $default;
        }
        return $value;
    }
}

?>