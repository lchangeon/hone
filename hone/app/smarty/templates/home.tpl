<!DOCTYPE html>
<html lang="en">
  <head>
    {include file='./common/meta.tpl'}
    {include file='./common/icon.tpl'}
    <link href="{$smarty.const.APPPATH}/css/stylesGeneric.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="{$smarty.const.APPPATH}/js/callmenu.js" type="text/javascript"></script>  
  </head>
	
  <body>
    
  <container>
    <header>
      {include file='./common/common_header_left.tpl'}
      {include file='./common/common_header_right.tpl'}
    </header>
	
    <main>
     
    <home_header>
        <div class="home_introduction">
            <h1>WELCOME !</h1> 
            <br>
            HONE is a PHP framework designed to implement WEB applications.<br>
            This page is an example of basic use of HONE framework.
        </div>
    </home_header>
    
    <main_container> 
    
     <div class="blog_pin">
        {assign var="content1" value=$smarty.const.APPPATH|cat:"/menu/content1"}
        
        <a href="{$content1}" target="_self">
            <h1>CONTENT 1</h1>
        </a>

        <div class="blog_pin_container"> 
            <a href="{$content1}" target="_self">        
                <div class="blog_pin_description ">
                    Click here to access<br>to first content.
                </div>
            </a>
        </div>        
     </div> 
     
     <div class="blog_pin">
        {assign var="content2" value=$smarty.const.APPPATH|cat:"/menu/content2"}
        
        <a href="{$content2}" target="_self">
            <h1>CONTENT 2</h1>
        </a>
                    
        <div class="blog_pin_container"> 
            <a href="{$content2}" target="_self">        
                <div class="blog_pin_description ">
                    Click here to access<br>to second content.
                </div>
            </a>
        </div>        
     </div> 

     <div class="blog_pin">
        {assign var="contact" value=$smarty.const.APPPATH|cat:"/contact"}
        
        <a href="{$contact}" target="_self">
            <h1>CONTACT</h1>
        </a>

        <div class="blog_pin_container"> 
            <a href="{$contact}" target="_self">        
                <div class="blog_pin_description ">
                    Any question ?
                </div>
            </a>
        </div>        
     </div>                                       
    </main_container>
        

   </main>
   	
    <footer>
      {include file='./common/common_disclaimer.tpl'}
    </footer>
    
   </container>
   
   

  
  </body>
</html>