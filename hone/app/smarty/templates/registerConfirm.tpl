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
            <span class="bold">Register confirmation<hr></span> 
        </div>

               
        <div class="containerBody">    

            
        <div class="containerProfile profileConfirm">                            

            <span class="row">
                <span class="col-50 right-justify">Last name</span>
                <span class="col-50 left-justify">{$userData->getLast_name()}</span>
            </span>

            <span class="row">
                <span class="col-50 right-justify">First name</span>
                <span class="col-50 left-justify">{$userData->getFirst_name()}</span>
            </span>

                 <span class="row">
                <span class="col-50 right-justify">Phone</span>
                <span class="col-50 left-justify">{$userData->getPhone()}</span>
            </span>
                    
            <span class="row">
                <span class="col-50 right-justify">Mail address</span>
                <span class="col-50 left-justify">{$userData->getPc_mail()}</span>
            </span>
                    
            <div class ="containerText center-justify">
                Some message ...                    
            </div>
                    
            <div class ="containerAction center-justify">
                <button type="submit" name="operation" value="modify" class="button big">MODIFY</button> 
                <button type="submit" name="operation" value="toroku" class="button big">CONFIRM</button> 
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