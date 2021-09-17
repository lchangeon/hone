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

namespace App\Models;
use App\Core\Model;
use App\Core\DAOFactory;

/**
 * Description of User_Model
 *
 */
class User_Model extends Model {

    protected $no  = '';  
    protected $user_id  = '';	    
    protected $date_entry  = '';  
    protected $date_update   = '';
    protected $first_name  = '';  
    protected $last_name   = '';  
    protected $phone = '';
    protected $accept_com  = 0; 
    protected $pc_mail   = '';       
    protected $passwd   = '';
    protected $salt = '';
    protected $to_reset   = '';
    protected $mail_confirmed = 0;
    protected $hash  = '';
            
    function __construct($row) {

        //Populate attributes from received data
        parent::__construct($row);

    }
    
    function passToReset(){
        $retcod = false;
        if($this->to_reset=='X')
            $retcod = true;
        return $retcod;
    }
    
    public function reset_password($pass, $salt){
        return DAOFactory::getUserDAO()->reset_password($this->getUser_id(), $pass, $salt);
    }

    public function confirm_mail(){
        $this->mail_confirmed = 1;
        return DAOFactory::getUserDAO()->confirm_mail($this->getUser_id());
    }
    
    public function updateProfile() {
       return DAOFactory::getUserDAO()->updateProfile($this);
    }
    
    
    public function findLastNumber() {
        return DAOFactory::getUserDAO()->findLastNumber();  
    }
    
    /***************************************************************************
     * DAO Delegations methods
     ***************************************************************************/
    
    public static function instance_find($dataSet) {
       return DAOFactory::getUserDAO()->find($dataSet); 
    }
    
    public static function instance_find_all($dataSet) {
       return DAOFactory::getUserDAO()->find_all($dataSet); 
    }
    
    public static function instance_create($objet) {
        return DAOFactory::getUserDAO()->insert($objet);
    }  
    


}
