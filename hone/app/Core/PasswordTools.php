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

class PasswordTools {

    public static function password_strenght($password){

        //Password should be at least 8 characters in length and should include at least one upper case letter, one number.
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return 3;
        }else{
            return FALSE;
        }
    }

    public static function password_compare($password1, $password2){

        if(strcmp($password1, $password2) !== 0) {
            return 2;
        }else{
            return FALSE;
        }
    } 
    
    public static function get_hashed_password($password, $salt){

        //We use blowfish encryption for 5 rounds
        $Blowfish_Pre = '$2a$05$';
        $Blowfish_End = '$';
    
        $bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End; 
        $hashed_password = crypt($password, $bcrypt_salt);
        
        return $hashed_password;
    }
    
        /*
    * Get a new random salt word to proceed to encryption 
    */
    public static function buildSalt(){
        
        // Blowfish accepts these characters for salts.
        $Allowed_Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        $Chars_Len = 63;
        $Salt_Length = 21;        
        
        $salt = "";
        for($i=0; $i< $Salt_Length; $i++) {
            $salt .= $Allowed_Chars[mt_rand(0, $Chars_Len)];
        }
        return $salt;
    }
}

