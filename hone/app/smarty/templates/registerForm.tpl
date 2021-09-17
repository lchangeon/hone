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

        <div class="containerHead">
            <span class="bold">Register<hr></span> 
        </div>
          
        <div class="containerBody">    

            
        <div class="containerProfile">                            
          <div class="boxBody"> 
            <span class="row">
                <span class="col-100 bold red center-justify">{$message}</span>
            </span>
            
            <span class="row">
                <span class="col-30 bold"><label>*: Required</label></span>
                <span class="col-70"></span>
            </span>
            <br> 
            <span class="row">
                <span class="col-30"><label> Last name *</label></span>
                <span class="col-70"><input type="text" name="last_name" placeholder="Hone" value="{if isset($userData)}{$userData->getLast_name()}{/if}" class="form-control" required></span>
            </span>

            <span class="row">
                <span class="col-30"><label> First name *</label></span>
                <span class="col-70"><input type="text" name="first_name" placeholder="John" value="{if isset($userData)}{$userData->getFirst_name()}{/if}" class="form-control" required></span>
            </span>

            <span class="row">
                <span class="col-30"><label> Phone</label></span>
                <span class="col-70"><input type="text" name="phone" placeholder="0901112222" value="{if isset($userData)}{$userData->getPhone()}{/if}" class="form-control phoneMasking" data-mask="000000000000000"></span>
            </span>
                    
            <span class="row">
                <span class="col-30"><label> Mail address *</label></span>
                <span class="col-70"><input type="text" name="pc_mail" placeholder="john.hone@domain.com" value="{if isset($userData)}{$userData->getPc_mail()}{/if}" class="form-control" required></span>
            </span>

            <span class="row">
                <span class="col-30"><label>Password *</label></span>
                <span class="col-70"><input type="password" id="password1" class="form-control" name="password1" placeholder="Password" value="{if isset($userData)}{$userData->getPasswd()}{/if}" required/></span>
            </span>
                    
            <span class="row">
                <span class="col-30"><label>Password confirmation *</label></span>
                <span class="col-70"><input type="password" id="password2" class="form-control" name="password2" placeholder="Password confirmation" value="{if isset($userData)}{$userData->getPasswd()}{/if}" required/></span>                    
            </span>

            <span class="row">
                <span class="col-30"></span>
                <span class="col-70 left-justify">

                <input type="checkbox" name="accept_com" {if isset($userData)}{if $userData->getAccept_com()}checked="checked"{/if}{else}checked="checked"{/if}/>&emsp;I accept to receive some news ...
                <br><br>
                Here come a message to explain guidance and other legal notices.
                <br><br>
                <input type="checkbox" name="accept_term" required/>&emsp;I accept the conditions of use of the service.*
                <br><br>
            </span> 
                
            <div class ="containerAction  center-justify">
                <button type="submit" name="operation" value="confirm" class="button big">REGISTER</button>                       
            </div>                    
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