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
use App\Core\Controller;
use App\Core\DAOFactory;
use App\Models as models;
use App\Core\Exceptions as exceptions;

/**
 * Description of login
 *
 */
class Login extends Controller{
    
    private $safePost;
    private $logtxt;

    function __construct() {
        parent::__construct();
        $this->logtxt = json_decode(LOGTXT);
    }
    
    public function index(){

        $this->safePost = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $operation = (isset($this->safePost['operation'])?$this->safePost['operation']:'');
        
        switch ($operation){
            case 'login': 
                $this->loginSubmit();
                break;
            case 'logout': 
                $this->logout();
                break;            
            case 'reset': 
                $this->loginReset();
                break;    
            case 'sendMail': 
                $requestedId = array('pc_mail'=>$this->safePost['sendToMail']);
                $userData = models\User_Model::instance_find($requestedId);
                if($userData != null){
                    $mail = new models\Mail_Model();
                    $mail->sendValidationMail($userData); 
                    $this->loginRequest($message = $this->logtxt[10]);
                } else {
                    $this->loginRequest($message = $this->logtxt[11]);
                }
                break;    
            case 'sendReset': 
                $requestedId = array('pc_mail'=>$this->safePost['pc_mail']);
                $userData = models\User_Model::instance_find($requestedId);
                if($userData != null){
                    $mail = new models\Mail_Model();
                    $mail->sendResetMail($userData); 
                    $this->loginForgotten($message = $this->logtxt[10]);
                } else {
                    $this->loginForgotten($message = $this->logtxt[13]);
                }
                break;  
                
            default:
                $this->loginRequest();
        }
         
    }
    
    public function getUser(){
        if(!isset($_SESSION['userid']))
            $_SESSION['userid'] = NULL;
        return $_SESSION['userid']; 
    }
            
            
    /*
    * Log in request form 
    */
    public function loginRequest($message = ''){
        $this->view->assign('formVariante', 'loginNormal');
        $this->view->assign('user', null);
        $this->view->assign('message', $message);
        $this->view->assign('sendMail', False);  
        $this->view->display('login.tpl');
    }

    /*
    * Forgotten credentials request form 
    */
    public function loginForgotten($message = ''){
        $this->view->assign('formVariante', 'loginForgotten');
        $this->view->assign('user', null);
        $this->view->assign('message', ($message==''?$this->logtxt[12]:$message));
        $this->view->display('login.tpl');
    }
    
    /*
    * Log in request form 
    */
    public function loginSendmail($message = '', $pc_mail = ''){
        $this->view->assign('formVariante', 'loginNormal');
        $this->view->assign('user', null);
        $this->view->assign('sendToMail', $pc_mail);
        $this->view->assign('message', $message);
        $this->view->assign('sendMail', True);        
        $this->view->display('login.tpl');
    }
    
    public function logout(){
        unset($_SESSION['userid']);
        
        //Initialization of Session variables as define in session starter configuration file
        $start_values = json_decode(START_VALUES);
        foreach($start_values as $key){
            $_SESSION[$key[0]] = $key[1];
        }
        header("Location: " . APPPATH.'/home');
        exit;     
    }
    
    public function passwordResetRequest($pc_mail, $message = ''){
        $this->view->assign('formVariante', 'loginReset');
        $this->view->assign('user', null);
        $this->view->assign('pc_mail', $pc_mail);
        $this->view->assign('message', $message);
        $this->view->display('login.tpl');
    }

    public function resetPassword($user_id, $hash){
        $requestedId = array('user_id'=>$user_id,
                              'hash'=>$hash);
        $userData = models\User_Model::instance_find($requestedId);
        if($userData!==NULL){
            $this->passwordResetRequest($userData->getPc_mail());         
        } else {
            header("Location: " . APPPATH.'/home');
            exit; 
        }
    }
    
    public function loginSubmit(){
        
        try{
                        
            //Get user's input
            $pc_mail = $this->safePost['pc_mail'];
            $pass   = $this->safePost['password'];

            //Request database
            $requestedId = array('pc_mail'=>$pc_mail);
            $user = models\User_Model::instance_find($requestedId);
          
            if($user != null){
                //Encrypt the pass gave by user in order to compare
                $hashed_pass = PasswordTools::get_hashed_password($pass, $user->getSalt());

                //User gave the correct password ...
                if ($hashed_pass == $user->getPasswd()) {

                    //... user needs to reset his password, we redirect him to reset form
                    if($user->passToReset()){
                        $this->loginResetRequest($pc_mail);

                    //... user's mail not confirmed yet    
                    } elseif($user->getMail_confirmed()==0) {
                        $this->loginSendmail($message = $this->logtxt[5], $pc_mail = $pc_mail);

                    //... all right, let's go to home    
                    } else {    
                        $_SESSION['userid'] = $user;
                        header("Location: " . APPPATH.'/home');
                        exit;
                    }

                //Password gave by user is wrong    
                } else {
                    $this->loginRequest($message = $this->logtxt[1]);  
                }
            
            //Email gave by user is unknown    
            } else {
                $this->loginRequest($message = $this->logtxt[1]); 
            }
            
        } catch (Exceptions\DAOConfigException $e){
            echo $e->getmessage(); 
        }  
    }
    
    public function loginReset(){
        
        try{
        
            //By defaut everything is all right
            $passCheck = FALSE;
                
            //Get user's input
            $pc_mail = $this->safePost['pc_mail'];
            $pass1   = $this->safePost['password1'];
            $pass2   = $this->safePost['password2'];

            $passCheck = PasswordTools::password_compare($pass1, $pass2);
            if($passCheck===FALSE){
                $passCheck = PasswordTools::password_strenght($pass1);
            }
            if($passCheck===FALSE){
                
                $salt = PasswordTools::buildSalt();
                $hashed_password = PasswordTools::get_hashed_password($pass1, $salt);
              
                $requestedId = array('pc_mail'=>$pc_mail);

                $user = models\User_Model::instance_find($requestedId);
                if($user!==NULL){
                    $retcod = $user->reset_password($hashed_password, $salt);
                    $this->loginRequest($this->logtxt[14]);
                    //$_SESSION['userid'] = $user;
                } else {
                    header("Location: " . APPPATH.'/home');
                    exit;
                }
                
            } else {
                $this->passwordResetRequest($pc_mail, $this->logtxt[$passCheck]);
            }

            
        } catch (Exceptions\DAOConfigException $e){
            echo $e->getmessage(); 
        }  
    } 
    
    
}
