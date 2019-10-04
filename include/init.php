<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

function requireClass($class_name) {
    require_once PATH_TO_ROOT.'../classes/'.$class_name.'.class.php';
}

spl_autoload_register('requireClass');

// start sessie
$session = new Session();

// maak nieuw pdo-object
$pdo = new MyPDO();


