<!DOCTYPE html>
<html lang="en">
  <head>
    {include file='./common/meta.tpl'}
    {include file='./common/icon.tpl'}
    <link href="{$smarty.const.APPPATH}/css/stylesGeneric.css" rel="stylesheet">
    <link href="{$smarty.const.APPPATH}/css/font-awesome.min.css" rel="stylesheet">       
    <link href="{$smarty.const.APPPATH}/css/stylesControles.css" rel="stylesheet">  
    <link href="{$smarty.const.APPPATH}/css/stylesProfile.css" rel="stylesheet">    
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="{$smarty.const.APPPATH}/js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="{$smarty.const.APPPATH}/js/callmenu.js" type="text/javascript" ></script>      
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
    
      <form method="post" name="contactForm" action="{$smarty.const.APPPATH}/contact/sendRequest">
          
        <div class="containerBody">    

            
            <div class="containerProfile">                            

   
<div class="boxWrapper">

    <div class ="boxAction">
        <span class="row">
            <span class="col-20"><label></label></span>
            <span class="col-80"><button type="submit" name="operation" value="sendRequest" class="button big"><i class="fa fa-envelope-o"></i><span>リクエスト送る</span></button></span>
        </span>
    </div>   

    <div class="boxBody">    
        <span class="row">
            <span class="col-30 bold"><label>*: Required</label></span>
            <span class="col-70 bold"></span>
        </span>
        <br>
        
        {assign var="last_name" value=""}
        {assign var="first_name" value=""}
        {assign var="pc_mail" value=""}
        {if $user != null}
            {assign var="last_name" value=$user->getLast_name()}
            {assign var="first_name" value=$user->getFirst_name()}
            {assign var="pc_mail" value=$user->getPc_mail()}        
        {/if}
            
        <span class="row">
            <span class="col-30"><label> Last Name *</label></span>
            <span class="col-70"><input type="text" name="last_name" placeholder="Hone" value="{$last_name}" class="form-control" required></span>
        </span>

        <span class="row">
            <span class="col-30"><label> First Name *</label></span>
            <span class="col-70"><input type="text" name="first_name" placeholder="John" value="{$first_name}" class="form-control" required></span>
        </span>

        <span class="row">
            <span class="col-30"><label> Mail *</label></span>
            <span class="col-70"><input type="text" name="pc_mail" placeholder="john.hone@domain.com" value="{$pc_mail}" class="form-control" required></span>
        </span>
        <span class="row">
            <span class="col-30"><label> Your request</label></span>
            <span class="col-70">
              <textarea name="request" rows=9  class="form-control">
              </textarea>
            </span>
        </span>

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