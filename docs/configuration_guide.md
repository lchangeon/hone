# **HONE FRAMEWORK**

##  **Installation and configuration instructions**

 

Hone framework is available as a simple and adaptable template project. It’s easy to capitalize on it and to implement more advanced websites or applications.

 The installation comes down to copying the source code (contents of the "hone" Github repo directory) to the destination of your choice. A configuration of the various paths is, of course, required, that is the subject of this document. In order to be clear, we will cover 2 possible scenarios: the installation and configuration of the framework on a local server on the one hand and on a hosted server on the other hand.

 

### *Scenario 1: Installing the framework locally*

 

#### Root directory

 In this scenario we have locally installed a WEB server like WAMP, XAMPP or even EasyPHP. Under the www root folder we have created a “myproject” directory intended to host our project. The tree structure therefore looks like this :

<pre>
 --- [www]

   |

   |---- [myproject]
</pre>
 

#### Copy of source code

 All we have to do is drop all the source code there (contents of the "hone" Github repo directory). The project should look like this :

 (Note that folders are shown with square brackets, files without)

<pre>
 --- [www]

   |

   |---- [myproject]

​        |

​        |---- [app]

​        |---- [public]

​        |---- [vendor]

​        |---- .htaccess

​        |---- composer.json
</pre>
 

#### Paths configuration

 We now have to configure the paths. 

-  We first go to the **app/config/app_ini.php** file and specify in the ROOTPATH variable the name of the directory in which we have pasted our project. By default, ROOTPATH is initialized with **/hone** in our example we will therefore set **/myproject**

  Here are what the first lines of the app.ini file should look like :

  ```php
  // ROOT SETUP
  //-----------------------------------------------
  //Here is the path to root as defined in domain definition settings
  define('ROOTPATH', '/myproject);
  
  // PATHS DEFINITION
  //-----------------------------------------------
  define('APPPATH', ROOTPATH.'/public');
  define('IMGPATH', APPPATH.'/img');
  define('DATAPATH', APPPATH.'/data');
  define('VDRPATH', APPPATH.'/../vendor');
  ```

   

- Next we go to the **public/.htaccess** file and specify in front of the RewriteBase instruction the path of the public directory. By default, the value of this path is **/hone/public** in our example we will therefore set /**myproject/public**

  ```
  RewriteBase /myproject/public
  ```

  

As it is, if our web server is running and, in our internet browser, we go to the address http://localhost/myproject or http://localhost:8080/myproject, we should see the page of home of the framework.

 

#### Remarks

 A few comments :

- If you have launched the framework as specified above you may have noticed that an automatic redirection has been established to the public directory. This is due to the .htaccess file present at the root of the project. Deleting this file will not affect the proper functioning of the project, however this will lead the browser to display the contents of the project directory when calling http://localhost/myproject which must be replaced by http://localhost/myproject/public.

  Please notice that, in the remote server configuration, we will see how to systematically remove the reference to the public directory from the URL,

- If you are working on source code via an IDE like NetBeans for example, it is recommended to modify the composer.json file in order to match the name of the project with the directory that hosts it. To this end, at the project root, in the **composer.json** file, replace the default value **vendor/hone** with the reference to your project, in our example **vendor/myproject**

 

### *Scenario 2: Installing the framework on a server hosted by a provider*

 

#### Root directory

In this scenario we rented a web space from a provider, we also have a domain name. For the purposes of this example, we are assuming that our web space is not reserved exclusively for this project. We have therefore created a “myproject“ directory (for example) at the root of our web space.

 

#### Copy of source code

First, we will drop all of the source code in our newly created “myproject” directory (contents of the "hone" Github repo directory). The web space for our project should look like this :

(Note that folders are shown with square brackets, files without)

<pre>
--- [/]

   |

   |---- [myproject]

​        |

​        |---- [app]

​        |---- [public]

​        |---- [vendor]

​        |---- .htaccess

​        |---- composer.json
</pre>
 

#### Document Root of domain

 The provider lets you, from its configuration interface, to link a web space directory with a domain name, this directory is called the document root of the domain. In our case, we will link our domain with the **/myproject/public** directory

Note: We could have just linked the domain with myproject directory but we do not want a reference to public directory to be visible in the URL, this is why we prefer to directly stipulate **/myproject/public**

 

#### Paths configuration

 We now have to configure the paths. 

1. We first go to the **app/config/app_ini.php** file and :

   - We specify an empty string in the ROOTPATH variable. We have indeed linked the domain to the public directory. By default, ROOTPATH is initialized with **/hone** in our example we will therefore put 2 quotes only, 

   - We remove the reference to the public directory specified in the APPPATH variable. By default, the value of APPPATH is ROOTPATH.'/Public' so we will put ROOTPATH. '' or just ROOTPATH

   Here are what the first lines of the app.ini file should look like:

   ```php
   // ROOT SETUP
   //-----------------------------------------------
   //Here is the path to root as defined in domain definition settings
   define('ROOTPATH', '');
   
   // PATHS DEFINITION
   //-----------------------------------------------
   define('APPPATH', ROOTPATH.'');
   define('IMGPATH', APPPATH.'/img');
   define('DATAPATH', APPPATH.'/data');
   define('VDRPATH', APPPATH.'/../vendor');
   ```

   

2. Next, we go to the public **/.htaccess** file and specify in front of the RewriteBase instruction the root **/**. By default, the value of this path is **/hone/public** in our example we will therefore put a simple slash: /

   ```
   RewriteBase /
   ```

   

 As it is, if we go to our internet browser and go to our domain address (for example http://mydomain.com), you should see the framework home page, without any reference to the public directory.

 

#### Remark

 The .htaccess file located at the root of the project directory is not necessary for the configuration detailed previously since the domain is linked to the public directory. This file will be necessary if you link your domain to your project directory or if you install your project on a local server (see the instructions in the first part of this document).

 

#### Member management / Database

Hone framework can perfectly be used for the implementation of a website without any database and, a fortiori, without member management. However, more advanced project will require a database.

The template project proposed by the framework illustrates the use of a MySQL database through a complete member management system. The registration of a new member, the validation of email addresses, profile pages, modifications as well as forgotten password management have been implemented in this template.

By default, member management is disabled in the template project. If you want to activate it in order to take full advantage of the framework's features and implement your project on top of it, please follow the instructions below.

Note: These instructions are valid both with local and hosted server.

1. activate the member management option
2. create a database
3. update the database connection parameters
4. set up an SMTP server

 

**1.**  **Activate the member management option**

You just have to go to the **app/config/app_ini** file and then set the value of the MEMBER_MANAGED parameter to True.

By default, this parameter is set to False. Setting it to True will make the project display the connection icon.

 

**2.**  **Create a database**

Then you have to create a database. As part of the installation example discussed in this guide, we will create a MySQL database, as expected by the template project. 

- We create, for example, a MySQL database named **db1** with the user **dbuser** and the password **dbpass**

- We then add to this database a table named **user**. Below is the SQL statement to create this table with the structure expected by the template project:

  ```sql
  CREATE TABLE `user` (
   `num` int(10) NOT NULL,
   `user_id` varchar(7) NOT NULL,
   `date_entry` datetime NOT NULL,
   `date_update` datetime NOT NULL,
   `first_name` varchar(15) NOT NULL,
   `last_name` varchar(15) NOT NULL,
   `phone` varchar(10) NOT NULL,
   `accept_com` tinyint(1) NOT NULL,
   `pc_mail` varchar(20) NOT NULL,
   `passwd` varchar(64) NOT NULL,
   `salt` varchar(64) NOT NULL,
   `to_reset` char(1) NOT NULL,
   `mail_confirmed` tinyint(1) NOT NULL,
   `hash` varchar(32) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  
  ALTER TABLE `user`
   ADD PRIMARY KEY (`num`);
  
  ALTER TABLE `user`
   MODIFY `num` int(10) NOT NULL AUTO_INCREMENT;
  ```

  

 **3.**  **Update the database connection parameters**

Once the database is created, you have to tell the framework how to connect to it. This can be done through the **app/config/db_ini** file

As you can see, it’s possible to set the driver, by default "mysql", the host address, as well as the name of the database, the user and the password.

```php
define('DRIVER', 'mysql');
define('HOST', 'localhost');
define('DBNAME', 'db1');
define('USERNAME', 'dbuser');
define('PASSWORD', 'dbpass');
```

 

**4.**  **Set up an SMTP server**

 An SMTP server is only required for sending confirmation emails, as part of member management. If you have a provider, the SMTP parameters may be available via its configuration interface. Otherwise, if you work locally for example, or only want to proceed some tests, be aware that there are free limited SMTP services available on the net.

 The configuration of the SMTP server is located in the **app/config/app_ini** file

You will be able to specify the host, port, security protocol (default TLS), user (login) and password.

 The sender's email address (your project) and his name are also included in the settings. Please note that some SMTP servers require you to declare the domain from which you send e-mails.

 

```php
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
```

