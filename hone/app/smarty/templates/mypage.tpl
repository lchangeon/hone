<!DOCTYPE html>
<html lang="en">
  <head>
    {include file='./common/meta.tpl'}
    {include file='./common/icon.tpl'}
    <link href="{$smarty.const.APPPATH}/css/font-awesome.min.css" rel="stylesheet">    
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
      <form method="post" name="profileForm" action="{$smarty.const.APPPATH}/mypage">
          
        <input type="hidden" name="selectedTab" value="{$selectedTab}"/>
        
        <div class="profile_pin_wrapper">
            <div class="profile_pin_container">
                <div class="profile_pin {if $selectedTab == 0}selected_pin{/if}">
                   <button type="submit" name="operation" value="tabProfile" class="button_link">            
                       <img src="{$smarty.const.APPPATH}/img/icon_login.png" border="0" alt="keywords"/>
                        <h1>Profile</h1>
                   </button>
                </div> 

                <div class="profile_pin {if $selectedTab == 1}selected_pin{/if}">
                   <button type="submit" name="operation" value="tabSecurity" class="button_link">            
                       <img src="{$smarty.const.APPPATH}/img/icon_security.png" border="0" alt="keywords"/><br>
                       <h1>Security</h1>
                   </button>
                </div>                        
            </div>                        
        </div>     
        
        <div class="containerBody">    

            
            <div class="containerProfile">                            

               
                {if $selectedTab == 1}  
                    {include file='./security.tpl'}                    

                {else}    
                    {include file='./profile.tpl'}
                {/if}

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