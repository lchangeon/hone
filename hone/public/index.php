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

// This index file is the entry point of the application. 
// Its role is to instantiate the router so that it can dispatch user requests
// through controllers and methods.
// Note : If no modification has been made in the project's organization, 
//        the paths below DO NOT NEED to be modified.

require '../vendor/autoload.php';
require_once '../app/config/exceptions_ini.php';
require_once '../app/config/db_ini.php';
require_once '../app/smarty/Smarty.class.php';
require_once '../app/config/app_ini.php';
require_once '../app/config/app_text.php';
require_once '../app/config/client_ini.php';
require_once '../app/config/session_starter.php';

use App\Core\Router;

$app = new Router();