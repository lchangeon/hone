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
use App\Models as models;


/**
 * Description of login
 *
 */
class Mypage extends Controller{

    private $safePost;
    private $logtxt;
    private $selectedTab;
            
    function __construct() {
        parent::__construct();
        $this->logtxt = json_decode(LOGTXT);
    }
    
    public function index(){

        $this->safePost = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $operation = explode('::', ((isset($this->safePost['operation'])?$this->safePost['operation']:'').'::'));

        $this->selectedTab = (isset($this->safePost['selectedTab'])?$this->safePost['selectedTab']:0);
        
        $user = $this->getUser();
        
        //Direct action from user was requested   ...
        switch ($operation[0]){
            case 'tabProfile':
                $this->selectedTab = 0;
                $this->profilView();
                break;

            case 'tabSecurity':
                $this->selectedTab = 1;
                $this->profilView();
                break;
            
            case 'profileUpdate':             
                $user->setFirst_name($this->safePost['first_name']);  
                $user->setLast_name($this->safePost['last_name']); 
                $user->setPhone($this->safePost['phone']); 
                $user->setAccept_com(isset($this->safePost['accept_com'])?1:0);                 

                $controlOK = True;
                $sendConfirmationMail = False;
                
                $message = $this->logtxt[6];
                
                if($this->safePost['pc_mail'] != $user->getPc_mail()){

                    //We check if there is already a user with requested mail
                    $requestedId = array('pc_mail'=>$this->safePost['pc_mail']);
                    $isUser = models\User_Model::instance_find($requestedId);
                    if($isUser!==NULL){
                        $message = $this->logtxt[4];
                        $controlOK = False;
                    } else {
                        $sendConfirmationMail = True;
                        $user->setPc_mail($this->safePost['pc_mail']); 
                        $user->setHash(md5(rand(0, 1000)));
                        $user->setMail_confirmed(0);    //Force mail confirmation before login 
                        //$message = new models\Message_Model('green', array(6, 5));
                    }
                }
                
                if($controlOK){
                    $retUpd = $user->updateProfile();
                    if($retUpd === FALSE){
                        $message = $this->logtxt[7];
                    } else {
                        $message = $this->logtxt[6];
                        
                        if($sendConfirmationMail){
                            $mail = new models\Mail_Model();
                            $mail->sendValidationUpdatedMail($user); 
                            $message .= $this->logtxt[10];
                        }
                    }
                }
                $this->profilView($message);                    
   
                break;     

            case 'securityUpdate':             

                  
                //Then we check if confirmation password is the same as original and its strenght
                $pass1   = $this->safePost['password1'];
                $pass2   = $this->safePost['password2'];

                $passCheck = PasswordTools::password_compare($pass1, $pass2);
                if($passCheck===FALSE){
                    $passCheck = PasswordTools::password_strenght($pass1);
                }
                
                if($passCheck===FALSE){
                    $user = $this->getUser();                    
                    //generate salt and hash password
                    $salt = PasswordTools::buildSalt();
                    $hashed_password = PasswordTools::get_hashed_password($pass1, $salt);
                    $user->setPasswd($hashed_password);                    
                    $user->setSalt($salt); 

                    $retUpd = $user->reset_password($hashed_password, $salt);
                    $message = $this->logtxt[6];
                    if($retUpd === FALSE){
                        $message = $this->logtxt[7];
                    }
                } else {
                    $message = $this->logtxt[$passCheck];
                }
                
                $this->profilView($message);                    
                break; 
                
            default:                 //by default cart is setted on step 1
                
                if($this->getUser() != NULL){
                    $this->profilView();
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

  
  
    /*
    * -- Method homeDisplay : Defaut method from home, call home view
    */    
    public function profilView($message = ''){
        $user = $this->getUser();
        $this->view->assign('user', $user);
        $this->view->assign('selectedTab', $this->selectedTab);
        $this->view->assign('message', $message);
        $this->view->display('mypage.tpl'); 
    }

}

