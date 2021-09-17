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

//========================================================
// PATHS DEFINITION
// -------------------------------------------------------
// In this section are defined the required paths.
// In order to help you to set up parameters correctly, 
// here are two scenarios :
// 
// Example 1 : Your project is hosted locally, in a directory 
//              called "myProject" inside the root (www) folder
//              
//    > define('ROOTPATH', '/myProject');
//    > define('APPPATH', ROOTPATH.'/public');
//    > define('IMGPATH', APPPATH.'/img');
//    > define('DATAPATH', APPPATH.'/data');
//    > define('VDRPATH', APPPATH.'/../vendor');
//    
//    Note : In this case "public" will appears in th url.          
//              
// Example 2 : Your project is hosted by a provider. 
//              
//    > define('ROOTPATH', '');
//    > define('APPPATH', ROOTPATH.'');
//    > define('IMGPATH', APPPATH.'/img');
//    > define('DATAPATH', APPPATH.'/data');
//    > define('VDRPATH', APPPATH.'/../vendor');          
//              
//    Note : As we don't want folder "public" to appears in th url,
//           we first make, with provider settings, document root
//           to point to folder "public".
//    
//                        
// ROOT SETUP
//-----------------------------------------------
//Here is the path to root as defined in domain definition settings
define('ROOTPATH', '/hone');


// PATHS DEFINITION
//-----------------------------------------------
define('APPPATH', ROOTPATH.'/public');
define('IMGPATH', APPPATH.'/img');
define('DATAPATH', APPPATH.'/data');
define('VDRPATH', APPPATH.'/../vendor');


//========================================================
// MEMBER MANAGEMENT
//========================================================
// if MEMBER_MANAGED option below is set to True, a "LOGIN"
// icon will appear. User will, then, be able to register,
// log in and access to a profile page. It, of course, requires
// a database as specified in documentation, and in db_ini file in
// this current folder.
// Please refer to the configuration and installation guide. 
define("MEMBER_MANAGED", False);

//========================================================
// SMPT SETUP
//========================================================
define("SMTP_HOST", "smtp.provider.com");
define("SMTP_PORT", "587");
define("SMTP_SEC", "tls");
define("SMTP_LOGIN", "smtpuser");
define("SMTP_PASS", "smtppass");

define("SENDER_MAIL", "contact@myproject.com");
define("SENDER_NAME", "MY PROJECT");



