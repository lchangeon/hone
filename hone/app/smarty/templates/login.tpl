<!DOCTYPE html>
<html lang="en">
  <head>
    {include file='./common/meta.tpl'}
    {include file='./common/icon.tpl'}
    <link href="{$smarty.const.APPPATH}/css/stylesGeneric.css" rel="stylesheet">
    <link href="{$smarty.const.APPPATH}/css/stylesLogin.css" rel="stylesheet">       
    <link href="{$smarty.const.APPPATH}/css/stylesControles.css" rel="stylesheet">    
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  </head>
	
  <body>
    
  <container>
    <header>
      {include file='./common/common_header_left.tpl'}
      {include file='./common/common_header_right.tpl'}
    </header>
	
    <main>
     
    <main_container> 
        <form action="{$smarty.const.APPPATH}/login" method="Post">
        <div class="login_title">
            <span>SIGN IN / MY PROFILE</span>
        </div> 
        <div class="login_tiers">
            Here is a message to welcome visitors and encourage them to register ... ...
        </div>     
        <div class="login_wrapper">
            <div class="login_left">
                
                {include file="./login/$formVariante.tpl"}  
                
            </div> 
            <div class="login_right">
                <div class="login_box_top">
                   Register
                </div> 
                <div class="login_box_middle_outer">
                    <div class="login_box_middle_inner">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas scelerisque massa a purus accumsan tincidunt. 
                    Quisque accumsan sed justo a egestas. Pellentesque sagittis et purus in dignissim.
                    Sed velit turpis, feugiat in faucibus non, ultricies ac odio. Praesent ac lectus aliquam, sagittis ex non, 
                    placerat velit. Mauris ut gravida purus.
                    </div> 
                </div>  
                <div class="login_box_bottom">
                    
                    <a href="{$smarty.const.APPPATH}/register" target="_self">
                        <span class="button big">
                            REGISTER
                        </span>
                    </a>

                </div> 
            </div> 
        </div> 
        </form>
    </main_container>
        

   </main>
   	
    <footer>
      {include file='./common/common_disclaimer.tpl'}
    </footer>
    
   </container>
   
   

  
  </body>
</html>