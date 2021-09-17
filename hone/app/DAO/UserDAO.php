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

namespace App\DAO;

use App\Core\DAO;
use App\Models as models;
use App\Core\Exceptions as exceptions;

/**
 * Description of UserDAO 
 *
 */
class UserDAO extends DAO{
    
    private $table;
    
    public function __construct($dbConnection) {
        parent::DAO($dbConnection);
        $this->table = 'user';
    }
    public function create($dataSet){
        
    }
    public function delete($dataSet){
        
    }
    public function update($dataSet){
    }
    
    public function find($dataSet){
        return parent::selectRowAsObject(models\User_Model::class, $this->table, $dataSet);  
    }
    
    public function find_all($dataSet){
        return parent::selectMultiRowsAsObjects(models\User_Model::class, $this->table, $dataSet); 
    }

    public function reset_password($userId, $pass, $salt){
        $update = parent::newUpdate();
        
        $update->table($this->table);
        $update->cols(['date_update', 'passwd', 'salt', 'to_reset']);
        $update->where('user_id = :user_id');
        $update->bindValues(['date_update' => date('Y-m-d H:i:s'),
                            'passwd' => $pass,
                            'salt' => $salt,
                            'to_reset' => '',            
                            'user_id' => $userId]);
                
        $result = parent::update_pb($update); 
    }

    public function confirm_mail($userId){
        $update = parent::newUpdate();
        
        $update->table($this->table);
        $update->cols(['mail_confirmed']);
        $update->where('user_id = :user_id');
        $update->bindValues(['mail_confirmed' => 1,
                             'user_id' => $userId]);
                
        $result = parent::update_pb($update); 
    }
    
    public function updateProfile($user){
        $update = parent::newUpdate();
        
        $update->table($this->table);
        $update->cols(['date_update',
                        'first_name',  
                        'last_name',  
                        'phone', 
                        'pc_mail',
                        'mail_confirmed',
                        'hash']);
        $update->where('user_id = :user_id');
        $update->bindValues(['date_update' => date('Y-m-d H:i:s'), 
                        'first_name' =>  $user->getFirst_name(),  
                        'last_name' =>  $user->getLast_name(), 
                        'phone' =>  $user->getPhone(), 
                        'pc_mail' =>  $user->getPc_mail(),
                        'mail_confirmed' =>  $user->getMail_confirmed(),
                        'hash' =>  $user->getHash(),
                        'user_id' =>  $user->getUser_id()]);
                
        $result = parent::update_pb($update); 
    } 
    
    public function findLastNumber(){

        $select = parent::newSelect();
        
        $select->from($this->table);
        $select->cols(['max(`user_id`) AS last']);
        $select->where("`user_id` >= :numfr");
        $select->where("`user_id` <= :numto");
        $select->bindValues(['numfr' => UID_FROM,
                             'numto' => UID_TO]);
        
        return parent::selectRow_pb($select); 

    }
    
    public function insert($objet){
        $insert = parent::newInsert();
        
        $insert->into($this->table);
        $insert->cols(['user_id',	    
                        'date_entry',  
                        'first_name',  
                        'last_name',  
                        'phone',
                        'accept_com',
                        'pc_mail',  
                        'passwd',
                        'salt',
                        'to_reset',   
                        'mail_confirmed',
                        'hash']);

    $insert->bindValues(['user_id' =>  $objet->getUser_id(),	    
                        'date_entry'   =>  date('Y-m-d H:i:s'),  
                        'first_name' =>  $objet->getFirst_name(),  
                        'last_name' =>  $objet->getLast_name(), 
                        'phone' =>  $objet->getPhone(),
                        'accept_com' =>  $objet->getAccept_com(),
                        'pc_mail'  =>  $objet->getPc_mail(),       
                        'passwd' =>  $objet->getPasswd(),
                        'salt' =>  $objet->getSalt(),
                        'to_reset' =>  $objet->getTo_reset(),   
                        'mail_confirmed' =>  $objet->getMail_confirmed(),
                        'hash' =>  $objet->getHash()]);
                
        $result = parent::insert_pb($insert);
        return $result;
    }
}
