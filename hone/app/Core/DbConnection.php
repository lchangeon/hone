<?php

/*
 * Copyright 2021 Ludovic CHANGEON 
 * License : LGPL-3.0-or-later
 * 
 * This file is part of Hone Framework.
 *
 * Hone Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Hone Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.

 * You should have received a copy of the GNU Lesser General Public License
 * along with Hone Framework.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Core;

use App\Core\Exceptions as exceptions;

/**
 * DbConnection : Connection to database
 * Class DbConnection is built as a singleton. PDO extension is used
 * to abstract database type.
 *
 */
class DbConnection {
    
    private static $instance = null;     //Db connection instance
    
    /**
    * Constructor
    */
    private function __construct()
    {
        
    }

    /**
    * getInstance : Create a new persistant PDO connection
    */
    public static function getInstance()
    {  
	try {
	    self::$instance = new \PDO(DRIVER.":host=".HOST.';dbname='.DBNAME, USERNAME, PASSWORD, array(\PDO::ATTR_PERSISTENT => true, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	    self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);  

            //Note : Port is not defined, that means default port 3306 is set.
            //In order to specify a different port PDO class has to be instanciated
            //with a connection string like 'mysql:dbname=xxxx;host=99.99.99.99;port=3333'
            //for example.
            
        } catch(\PDOException $e) {
	    throw new exceptions\DAOConfigException ($e->getMessage());  
	}
        return self::$instance;
    }    
}
