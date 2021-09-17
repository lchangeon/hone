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
 * Class Menu
 */

class Menu extends Controller{

    
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        header("Location: " . APPPATH.'/home');
        exit;   
    }
    
    public function getUser(){
        if(!isset($_SESSION['userid']))
            $_SESSION['userid'] = NULL;
        return $_SESSION['userid']; 
    }
    
/*
 * -- Views methods
 */    
    public function content1(){
        $user = $this->getUser();
        $this->view->assign('user', $user);
        $this->view->display('content1.tpl'); 
    }

    public function content2(){
        $user = $this->getUser();
        $this->view->assign('user', $user);
        $this->view->display('content2.tpl'); 
    }
 
}

