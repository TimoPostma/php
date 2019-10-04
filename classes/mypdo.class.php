<?php

/**
 * @author Jeroen van den Brink
 * @copyright 2019
 */

class MyPDO extends PDO {

	const DRIVER = 'mysql';
   	const HOST = '127.0.0.1';
   	const PORT = '3306';
   	const DBNAME = 'php_toets_3_pannenkoeken';
   	const USERNAME  = 'noorderpoort';
   	const PASSWORD = 'toets';

	public function __construct() {
		
        $dsn = self::DRIVER . ':host=' . self::HOST . ';port='.self::PORT . ';dbname='.self::DBNAME;
		
        parent::__construct($dsn, self::USERNAME, self::PASSWORD);
		
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}
}


?>