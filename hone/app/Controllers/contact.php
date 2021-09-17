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

namespace App\Controllers;

use App\Core\Controller;
use App\Models as models;


/**
 * Class Contact
 *
 */
class Contact extends Controller{

    private $safePost;
    
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->contactDisplay();  
    }

    public function getUser(){
        if(!isset($_SESSION['userid']))
            $_SESSION['userid'] = NULL;
        return $_SESSION['userid']; 
    }
    
    public function sendRequest(){    
        
        $this->safePost = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        $newRequest = new models\Request_Model(['lastName' =>  $this->safePost['last_name'],
                                                'firstName' =>  $this->safePost['first_name'],
                                                'mail' =>  $this->safePost['pc_mail'], 
                                                'request' =>  $this->safePost['request']]);

        if($newRequest!==NULL){
            $mail = new models\Mail_Model();
            $mail->sendRequestMail($newRequest);                            
        }

        $this->contactDisplay(); 

    }
    
    public function contactDisplay(){
        $user = $this->getUser();
        $this->view->assign('user', $user); 
        $this->view->display('contact.tpl'); 
    }
    
}

