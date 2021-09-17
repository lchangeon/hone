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

use App\Controllers as controllers;
use App\Core\Exceptions as exceptions;

/**
 * Router : Custom routing class
 *
 */
class Router {

    function __construct() {
       
        //Creates a session or resumes the current one 
        session_start();
       ini_set('display_errors', 'on');
       
        //Was current session initiated ?
        if (!isset($_SESSION['initiated'])) {
            session_regenerate_id();
            
            //Initialization of Session variables as define in session starter configuration file
            $start_values = json_decode(START_VALUES);
            foreach($start_values as $key){
                $_SESSION[$key[0]] = $key[1];
            }
        } 

        //New HttpRequest object is instanciated from request ...
        try { 
            $httpRequest = new Request();
            $url = $httpRequest->getParts();
            
        } catch (Exceptions\InvalidHttpRequestException $e) { 
            echo $e->getMessage();
        } 
        
        //If any controller has been stipulated, we go to home/index by default
        if(empty($url[0])){
            header("Location: " . APPPATH.'/home');
            exit;            
        } 

        //As controllers to instantiate are determinated dynamically, it is
        //necessary to build the string first instead of setting the namespace
        //to use
        $requestedController = 'App\Controllers\\'.$url[0];
        try { 

            //The requested controller does not exist : we throw an exception
            //in order to catch the fatal error that will be generated
            if (!class_exists($requestedController)) { 
              throw new exceptions\ClassNotFoundException (CLASS_NOT_FOUND_MESSAGE); 
            } 

            //Instantiation of the requested controller
            $controller = new $requestedController; 
            
            //This part of url has been processed, we unset it. So we'll be
            //able to get parameters as array values 
            unset($url[0]);
            
            //if method is stiplulated ...
            if(isset($url[1])){
            
                $method = $url[1];
                
                //... and exist ...
     	        if (method_exists($controller, $method)) {
                    
                    //we unset it from url
                    unset($url[1]);
                
                    //we isolate parameters
                    $params = $url ? \array_values($url) : array();
                    
                    //if the method requests the httpRequest object, we add it
                    //as first element in parameters array before the call
                    if($this->isRequestArg($controller, $method)){
                        array_unshift($params, $httpRequest); 
                    }
                    
                    //and finally call the method of requested controller
                    //with parameters
                    $r = new \ReflectionMethod($controller, $method);
                    if($r->getNumberOfRequiredParameters() > sizeof($params)){
                        header("Location: " . APPPATH.'/home');
                        exit;                       
                    } else {
                        call_user_func_array(array($controller, $method), $params);
                    }

	        } else {
		    $controller->index();
                    return false;
	        }         
            } else {
                $controller->index();
                return false;
            }            
        } catch (exceptions\ClassNotFoundException $e) { 
            echo $e->getMessage();
            //$this->error();
        } 
    }

   /* function error() {
	$controller = new controllers\Error();
	$controller->index();
	return false;
    }*/
   
    /*
     * Is the first parameter of method @method in class @controller
     * from type Request
     * Action methods in controllers can request the httpRequest object,
     * the only condition is that it must be the first argument of the method.
     * In that case the system will add the request object and pass it with the
     * others arguments
     */
    function isRequestArg($controller, $method){
    
        $reflection = new \ReflectionClass($controller);
        $params = $reflection->getMethod($method)->getParameters();
        if(isset($params[0])){
            if($params[0]->getClass() != NULL) {
                $type = $params[0]->getClass()->name;
                return ($type==='App\Core\Request');
            }    
        }
        return FALSE;
    }
    
    
}
