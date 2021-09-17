    <div class="login_box_top">
        Sign in
    </div>
    
    <div class="login_box_middle_outer">
        <div class="login_box_middle_inner">
                        
            <label for="pc_mail" class="left-justify">Mail address</label>
            <input type="text" id="pc_mail" class="form-control" name="pc_mail" placeholder="Mail address"/>
            <label for="password" class="left-justify">Password</label>
            <input type="password" id="password" class="form-control" name="password" placeholder="Password"/>
                      
            <div class="login_message">
                {$message}
            </div>
            
        </div> 
    </div> 
            
    <div class="login_box_bottom">
        {if $sendMail}
            <input type="hidden" name="sendToMail" value="{$sendToMail}"/>
            <button type="submit" class="button big" name="operation" value="sendMail">SEND MAIL</button>
        {else}
            <span class="link_login">
                <a href="{$smarty.const.APPPATH}/login/loginForgotten" target="_self">Forgot password</a>
            </span>
        {/if}
        
        <button type="submit" class="button big" name="operation" value="login">SIGN IN</button>

    </div>
   