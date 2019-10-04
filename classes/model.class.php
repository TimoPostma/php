<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

abstract class Model {
    
    protected $pdo;
    
    protected $data;
    
    private $errors;
    
    private $loaded;
    
    public function __construct(MyPDO $pdo)
    {
        $this->pdo = $pdo;
        $this->loaded = false;
    }
    
    public function getError($key)
    {
        return $this->errors[$key] ?? '';
    }
    
    protected function setError($key, $message)
    {
        $this->errors[$key] = $message;
    }
    
    public function getErrors()
    {
        return $this->errors;    
    }
    
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
    
    public function hasNoErrors()
    {
        return empty($this->errors);
    }
    
    public function getLoaded()
    {
        return $this->loaded;
    }
    
    protected function setLoaded($value)
    {
        $this->loaded = $value;
    }
    
}