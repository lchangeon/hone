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

use App\Core\PasswordTools;
use App\Core\MailTools;
use App\Core\Controller;
use App\Models as models;


/**
 * Register class
 *
 */
class Register extends Controller{

    private $safePost;
    private $logtxt;
    
    function __construct() {
        parent::__construct();
        $this->logtxt = json_decode(LOGTXT);
    }
    
    public function index(){

        $this->safePost = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $operation = explode('::', ((isset($this->safePost['operation'])?$this->safePost['operation']:'').'::'));

        
        //Direct action from user was requested   ...
        switch ($operation[0]){
            case 'confirm':             

                //By defaut everything is all right
                $passCheck = FALSE;
                
                //First we check if there is already a user with requested mail
                $requestedId = array('pc_mail'=>$this->safePost['pc_mail']);
                $isUser = models\User_Model::instance_find($requestedId);
                if($isUser!==NULL){
                    $passCheck = 4; 

                } else { 
                    
                    
                    //Then we check if confirmation password is the same as original and its strenght
                    $pass1   = $this->safePost['password1'];
                    $pass2   = $this->safePost['password2'];

                    $passCheck = PasswordTools::password_compare($pass1, $pass2);
                    if($passCheck===FALSE){
                        $passCheck = PasswordTools::password_strenght($pass1);
                    }
                }
                
                //Controls are ok, we proceed to user's data buffering 
                $newUser = new models\User_Model(['user_id' => '',	    
                       'date_entry' => date('Y-m-d H:m:i'),  
                       'first_name' => $this->safePost['first_name'],  
                       'last_name' => $this->safePost['last_name'], 
                       'phone' => $this->safePost['phone'],
                       'accept_com' => (isset($this->safePost['accept_com'])?1:0),   
                       'pc_mail' => $this->safePost['pc_mail'],       
                       'passwd' => $this->safePost['password1'],
                       'mail_confirmed' => 0]);

                    $_SESSION['userData'] = $newUser;
                    
                    if($passCheck===FALSE){
                        $this->registerConfirm($newUser);
                    } else {
                        $this->registerForm($newUser, $this->logtxt[$passCheck]);
                    }
   
                break;     
            
            case 'modify':

                if(isset($_SESSION['userData'])){
                    $this->registerForm($_SESSION['userData'], '');
                } else {
                    $this->registerForm(NULL, '');
                }
                
                break; 

            case 'toroku':

                if(isset($_SESSION['userData'])){
                    //get user's data from session
                    $userData = $_SESSION['userData'];
                    
                    //generate unique ID for mail confirmation
                    $userData->setHash(md5(rand(0, 1000)));

                    //generate salt and hash password
                    $salt = PasswordTools::buildSalt();
                    $hashed_password = PasswordTools::get_hashed_password($userData->getPasswd(), $salt);
                    $userData->setPasswd($hashed_password);                    
                    $userData->setSalt($salt);  
                    
                    //compute next free user id and set it
                    $lastNumber = $userData->findLastNumber(); 
                    $userId = UID_FROM;
                    if($lastNumber['last'] != '') {
                        $userId = ++$lastNumber['last'];                    
                    }   
                    $userData->setUser_id($userId);
                    
                    $newUser = models\User_Model::instance_create($userData);
                    if($newUser!==NULL){
                        $mail = new models\Mail_Model();
                        $mail->sendValidationMail($userData);                            
                        $this->registerMessage($userData);
                    }
                    
                } 
                
                break;
                
            default:                 //by default cart is setted on step 1
                
                if($this->getUser() == NULL){
                    $this->registerForm(NULL, NULL, '');
                } else {
                    header("Location: " . APPPATH.'/home');
                    exit;                        
                } 
                
        }
    }

    public function getUser(){
        if(!isset($_SESSION['userid']))
            $_SESSION['userid'] = NULL;
        return $_SESSION['userid']; 
    }

    public function verify($user_id, $hash){
        $requestedId = array('user_id'=>$user_id,
                              'hash'=>$hash,
                              'mail_confirmed'=>0);
        $userData = models\User_Model::instance_find($requestedId);
        if($userData!==NULL){
            $userData->confirm_mail();
            $this->view->assign('user', null); 
            $this->view->assign('userData', $userData);           
            $this->view->display('mailConfirmed.tpl');           
        } else {
            header("Location: " . APPPATH.'/home');
            exit; 
        }
    }
    
    public function registerForm($userData, $message){
        $this->view->assign('user', null); 
        $this->view->assign('userData', $userData); 
        $this->view->assign('message', $message);          
        $this->view->display('registerForm.tpl'); 
    }

    public function registerConfirm($userData){
        $this->view->assign('user', null);        
        $this->view->assign('userData', $userData);       
        $this->view->display('registerConfirm.tpl'); 
    }
    
    public function registerMessage($userData){
        $this->view->assign('user', null);   
        $this->view->assign('userData', $userData);  
        $this->view->display('registerMessage.tpl'); 
    }
}

