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

use App\Core\PHPMailer\PHPMailer;

/**
 * Class Mail_Model 
 *
 */
class Mail_Model extends Model {

    protected $phpMailer;
    protected $root;
    
    function __construct() {
        
        parent::__construct();
        
        $this->phpMailer = new PHPMailer();
        
        $this->phpMailer->IsSMTP();                              // telling the class to use SMTP
        $this->phpMailer->SMTPAuth      = true;                  // enable SMTP authentication
        $this->phpMailer->Host          = SMTP_HOST; 
        $this->phpMailer->Port          = SMTP_PORT; 
        $this->phpMailer->Username      = SMTP_LOGIN;
        $this->phpMailer->Password      = SMTP_PASS;
        $this->phpMailer->SMTPSecure      = SMTP_SEC;
        $this->phpMailer->setFrom(SENDER_MAIL, SENDER_NAME);
        
        $this->root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    }
    
    public function sendRequestMail($request){

        $this->phpMailer->WordWrap = 50;
        $this->phpMailer->ClearAddresses();
        $this->phpMailer->AddAddress("lchangeon@gmail.com");
        $this->phpMailer->Subject = "subject";
        $this->phpMailer->Body = "body with eventually informations from <request> object"; 

        $this->phpMailer->Send();

    }
    
    public function sendValidationMail($user){

        $this->phpMailer->WordWrap = 50;
        $this->phpMailer->ClearAddresses();
        $this->phpMailer->AddAddress($user->getPc_mail());
        $this->phpMailer->Subject = "Your registration";

        $this->phpMailer->Body = $user->getLast_name()."、\n"
                  ."Thanks for joining us ...\n"
                  ."In order to confirm your mail address, please click on the link below :\n"
                  .$this->root.APPPATH."/register/verify/".$user->getUser_id()."/".$user->getHash(); 

         $this->phpMailer->Send();

    }
    public function sendValidationUpdatedMail($user){

        $this->phpMailer->WordWrap = 50;
        $this->phpMailer->ClearAddresses();
        $this->phpMailer->AddAddress($user->getPc_mail());
        $this->phpMailer->Subject = "Profile updated";

        $this->phpMailer->Body = $user->getLast_name()."、\n"
                  ."You updated your mail address !\n"
                  ."In order to confirm your new mail address, please click on the link below :\n"
                  .$this->root.APPPATH."/register/verify/".$user->getUser_id()."/".$user->getHash(); 

         $this->phpMailer->Send();

    }
    
    public function sendResetMail($user){

        $this->phpMailer->WordWrap = 50;
        $this->phpMailer->ClearAddresses();
        $this->phpMailer->AddAddress($user->getPc_mail());
        $this->phpMailer->Subject = "Password reset request";

        $this->phpMailer->Body = $user->getLast_name()."、\n"
                  ."You asked to reset your password, please click on the link below :\n"
                  .$this->root.APPPATH."/login/resetPassword/".$user->getUser_id()."/".$user->getHash(); 

         $this->phpMailer->Send();

    }
    
}

