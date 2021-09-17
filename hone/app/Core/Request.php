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

/**
 * Request : Http informations from page request are stored in object instanciated
 *           from this class. 
 *
 */
class Request
{
    // URL of the request
    private $url = null;

    // method (type) of the request : GET or POST
    private $method = null;

    // parsed parts of the URL
    private $parts = null;

    // post or cookie parameters
    private $data = null;

    /*
     * Constructor
     */
    public function __construct() {

        //we determine the method ...
        $this->method = $this->filter_input_fix(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING); 
   
        //... and make sure it's filled ...
        if(empty($this->method)) {
            throw new Exceptions\InvalidHttpRequestException(HTTP_REQUEST_MESSAGE);
        }
        
        //... and a valid one ...
        if(!in_array($this->method, array('GET', 'POST', 'PUT', 'DELETE', 'HEAD'))){
            throw new Exceptions\InvalidHttpRequestException(HTTP_REQUEST_MESSAGE);
        }    
    
        //we get the url ...
        $this->url = filter_input(INPUT_GET, 'url'); 
        
        //...and proceed to parsing
        $this->parseUrl();
    }

    /*
     * Parsing process
     */
    public function parseUrl()
    {
        $this->parts = explode('/', filter_var(rtrim($this->url, '/'), FILTER_SANITIZE_URL));
    }
    
    /*
     * Return request itself
     */
    public function getRequest()
    {
        return $this;
    }

    /*
     * Get parameters
     */
    public function getData()
    {
        //Data property is first set as generic empty class
        $this->data = new stdClass();

        //We extract then parameters from global variables
        $postParameters = filter_input_array(INPUT_POST);
        $cookieParameters = filter_input_array(INPUT_COOKIE);

        //If there, post parameters are scanned and stored in data property
        if(!is_null($postParameters))
        {
            foreach($postParameters as $parameter => $value)
            {
                if(!isset($this->data->postParameters))
                {
                    $this->data->postParameters = new stdClass();
                }

                $this->data->postParameters->{$parameter} = $value;
            }
        }

        //If there, cookie parameters are scanned and stored in data property
        if(!is_null($cookieParameters))
        {
            foreach($cookieParameters as $parameter => $value)
            {
                if(!isset($this->data->cookieParameters))
                {
                    $this->data->cookieParameters = new stdClass();
                }

                $this->data->cookieParameters->{$parameter} = $value;
            }
        }
    }



    /*
     * Returns the requested URL
     */
    public function getURL()
    {
        return $this->url;
    }

    /*
     * Returns the request type
     */
    public function getMethod()
    {
        return $this->method;
    }

    /*
     * Returns the request type
     */
    public function getParts()
    {
        return $this->parts;
    }

    //This method has been implemented in order to fix a bug that can occur on INPUT_SERVER / REQUEST_METHOD
    //and results in an empty return value
    public function filter_input_fix ($type, $variable_name, $filter = FILTER_DEFAULT, $options = NULL )
    {
        $checkTypes =[
            INPUT_GET,
            INPUT_POST,
            INPUT_COOKIE
        ];

        if ($options === NULL) {
            $options = FILTER_NULL_ON_FAILURE;
        }

        if (in_array($type, $checkTypes) || filter_has_var($type, $variable_name)) {
            return filter_input($type, $variable_name, $filter, $options);
        } else if ($type == INPUT_SERVER && isset($_SERVER[$variable_name])) {
            return filter_var($_SERVER[$variable_name], $filter, $options);
        } else if ($type == INPUT_ENV && isset($_ENV[$variable_name])) {
            return filter_var($_ENV[$variable_name], $filter, $options);
        } else {
            return NULL;
        }
    }
}
