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

use App\DAO as dao;
use App\Core\Exceptions as exceptions;

/**
 * DAOFactory : DAOFactory will not be instanciated, but will create DAO
 * layers on demand. As the factory requests an instance of DB connection
 * it can catch an exception it has to re-throw in order to inform final
 * controller which try to instanciate DAO object
 *
 */
class DAOFactory {
    
    /**
    * getDbInstance : Return the instance of DB connection or re-throw
    * the DAO configuration exception if there
    * AS DbConnection's getInstance called method is static, getDbInstance is
    * declared static   
    *
    */    
    private static function getDbInstance(){
        try{
            $dbc = DbConnection::getInstance();        
            return $dbc;   
        } catch (Exceptions\DAOConfigException $e){
            throw new exceptions\DAOConfigException ($e->getMessage());  
        }
    }
    
    /**
    * getUserDAO : Create new DAO for User   
    *
    */       
    public static function getUserDAO(){
        return new dao\UserDAO(self::getDbInstance());
    } 
    
}
