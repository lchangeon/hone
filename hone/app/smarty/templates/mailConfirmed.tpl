<!DOCTYPE html>
<html lang="en">
  <head>
    {include file='./common/meta.tpl'}
    {include file='./common/icon.tpl'}
    <link href="{$smarty.const.APPPATH}/css/stylesGeneric.css" rel="stylesheet">
    <link href="{$smarty.const.APPPATH}/css/stylesControles.css" rel="stylesheet">    
    <link href="{$smarty.const.APPPATH}/css/stylesProfile.css" rel="stylesheet">     
    <link href="{$smarty.const.APPPATH}/css/progress-wizard.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="{$smarty.const.APPPATH}/js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="{$smarty.const.APPPATH}/js/callmask.js" type="text/javascript"></script>    
  </head>
	
  <body>
    
  <container>
    <header>
      {include file='./common/common_header_left.tpl'}
      {include file='./common/common_header_right.tpl'}
    </header>
	
    <main>
     
    
    <main_container> 
      <form method="post" name="profileForm" action="{$smarty.const.APPPATH}/register">

        <input type="hidden" var="userData" value="$userData"/>   
                  
        <div class="containerHead">
            <span class="bold">Mail confirmed<hr></span> 
        </div>
               
        <div class="containerBody">    

            
        <div class="containerProfile profileConfirm">                            

            <div class ="containerText center-justify">
                {$userData->getLast_name()} {$userData->getFirst_name()}, your mail is confirmed !<br>
                You can now sign in ...
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