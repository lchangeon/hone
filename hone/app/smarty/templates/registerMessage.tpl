<!DOCTYPE html>
<html lang="en">
  <head>
    {include file='./common/meta.tpl'}
    {include file='./common/icon.tpl'}
    <link href="{$smarty.const.APPPATH}/css/stylesGeneric.css" rel="stylesheet">
    <link href="{$smarty.const.APPPATH}/css/stylesProfile.css" rel="stylesheet">
    <link href="{$smarty.const.APPPATH}/css/progress-wizard.min.css" rel="stylesheet">
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
        <form method="post" name="disp">
          
            <input type="hidden" var="userData" value="$userData"/>   
            <div class="containerHead">
  
            </div>
            
            <div class="containerBody">      
                <div class="containerMessage">   
                    {$userData->getLast_name()} {$userData->getFirst_name()},<br>
                    <span class="green bold">Thank you for joining us ...</span><br><br>
                    <u>Important</u>　:　An email has been sent to the specified email address. <br>
                     Please click the included link to confirm your email address. <br>
                     Once verified, you will be able to log in to your account.
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